
<template id="module-editor-card-slider-template">
  <div class="card-slider-editor">
    <div class="top-spacing"></div>
    
    {{-- Module Width --}}
    <div class="editor-section">
      <div class="section-title">Module Width</div>
      <div class="section-content">
        <div class="segmented-buttons">
          <div 
            :class="['segmented-btn', { active: form.width === 'narrow' }]" 
            @click="form.width = 'narrow'"
          >
            Narrow
          </div>
          <div 
            :class="['segmented-btn', { active: form.width === 'wide' }]" 
            @click="form.width = 'wide'"
          >
            Wide
          </div>
          <div 
            :class="['segmented-btn', { active: form.width === 'full' }]" 
            @click="form.width = 'full'"
          >
            Full Width
          </div>
        </div>
      </div>
    </div>

    {{-- Module Title --}}
    <div class="editor-section">
      <div class="section-title">Module Title</div>
      <div class="section-content">
        <text-i18n 
          v-model="form.title" 
          @change="onChange" 
          placeholder="Enter module title"
        ></text-i18n>
      </div>
    </div>

    {{-- Display Settings --}}
    <div class="editor-section">
      <div class="section-title">Display Settings</div>
      <div class="section-content">

        {{-- Items per row --}}
        <div class="setting-group">
          <div class="setting-label">Items per row</div>
          <div class="segmented-buttons">
            <div :class="['segmented-btn', { active: form.items_per_row === 2 }]" @click="form.items_per_row = 2">
              2 Items
            </div>
            <div :class="['segmented-btn', { active: form.items_per_row === 3 }]" @click="form.items_per_row = 3">
              3 Items
            </div>
            <div :class="['segmented-btn', { active: form.items_per_row === 4 }]" @click="form.items_per_row = 4">
              4 Items
            </div>
            <div :class="['segmented-btn', { active: form.items_per_row === 6 }]" @click="form.items_per_row = 6">
              6 Items
            </div>
          </div>
        </div>

        {{-- Autoplay --}}
        <div class="setting-group">
          <div class="setting-label">Autoplay</div>
          <div class="switch-wrapper">
            <el-switch 
              v-model="form.autoplay" 
              @change="onChange"
              :disabled="form.screens.length > 1" 
              active-text="Enabled" 
              inactive-text="Disabled"
              size="small"
            ></el-switch>
          </div>

          <div v-if="form.screens.length > 1" class="form-tip">
            <i class="el-icon-info"></i>
            Please remove extra screens before disabling autoplay
          </div>
        </div>

      </div>
    </div>

    {{-- Product Content --}}
    <div class="editor-section">
      <div class="section-title">Product Content</div>
      <div class="section-content">
        <div class="tab-container">

          <el-tabs v-model="activeTab" type="card" @tab-click="handleTabClick" class="custom-tabs">
            <el-tab-pane 
              v-for="(screen, index) in form.screens" 
              :key="index" 
              :label="'Screen ' + (index + 1)"
              :name="index"
            >
              <div class="screen-content">

                {{-- Product Search --}}
                <div class="search-section">
                  <div class="section-subtitle">Add Products</div>
                  <el-autocomplete 
                    class="search-input" 
                    v-model="keyword" 
                    value-key="name" 
                    size="small"
                    :fetch-suggestions="querySearch" 
                    placeholder="Search products by keyword" 
                    :highlight-first-item="true"
                    @select="handleSelect"
                    style="width: 100%;"
                  ></el-autocomplete>
                </div>

                {{-- Product List --}}
                <div class="products-section">
                  <div class="section-subtitle">Selected Products</div>
                  <div class="products-list" v-loading="loading">

                    <template v-if="screen.products.length">
                      <draggable 
                        ghost-class="dragabble-ghost" 
                        :list="screen.products" 
                        @change="itemChange"
                        :options="{ animation: 330 }"
                        class="products-draggable"
                      >
                        <div v-for="(item, index) in screen.products" :key="index" class="product-item">
                          <div class="product-info">
                            <div class="drag-handle">
                              <i class="el-icon-rank"></i>
                            </div>
                            <div class="product-preview">
                              <img :src="thumbnail(item.image_big)" class="preview-img">
                            </div>
                            <div class="product-details">
                              <div class="product-name">${ item.name }</div>
                              <div class="product-price">${ item.price_format }</div>
                            </div>
                          </div>

                          <div class="product-actions">
                            <el-button 
                              type="danger" 
                              size="mini" 
                              icon="el-icon-delete" 
                              circle
                              @click="removeProduct(index)"
                            ></el-button>
                          </div>
                        </div>
                      </draggable>
                    </template>

                    <div v-else class="empty-state">
                      <i class="el-icon-shopping-cart-2"></i>
                      <p>No products available. Please search and add above.</p>
                    </div>

                  </div>
                </div>

              </div>
            </el-tab-pane>
          </el-tabs>

          {{-- Screen Actions --}}
          <div class="screen-actions">
            <el-button 
              type="primary" 
              size="small" 
              @click="addScreen" 
              :disabled="!form.autoplay"
              icon="el-icon-plus"
            >
              Add Screen
            </el-button>

            <el-button 
              type="danger" 
              size="small" 
              @click="removeScreen"
              :disabled="form.screens.length <= 1"
              icon="el-icon-delete"
            >
              Remove Current Screen
            </el-button>
          </div>

        </div>
      </div>
    </div>
  </div>
</template>


<script type="text/javascript">
  Vue.component('module-editor-card-slider', {
    delimiters: ['${', '}'],
    template: '#module-editor-card-slider-template',
    props: ['module'],
    data: function() {
      return {
        keyword: '',
        productData: [],
        loading: null,
        debounceTimer: null,
        form: {
          screens: [{
            products: []
          }],
          items_per_row: 4,
          activeTab: 0,
          autoplay: true,
          width: 'wide',
          title: {}
        },
        activeTab: 0
      }
    },
    watch: {
      form: {
        handler: function(val) {
          this.onChange();
        },
        deep: true
      }
    },
    created: function() {
      if (this.module) {
        this.form = JSON.parse(JSON.stringify(this.module));
      }

     
      if (!this.form.screens || !Array.isArray(this.form.screens)) {
        this.$set(this.form, 'screens', [{
          products: []
        }]);
      }

      
      this.form.screens.forEach(screen => {
        if (!screen.products || !Array.isArray(screen.products)) {
          this.$set(screen, 'products', []);
        }
      });

      if (!this.form.items_per_row) {
        this.$set(this.form, 'items_per_row', 4);
      }

      if (typeof this.form.activeTab === 'undefined') {
        this.$set(this.form, 'activeTab', 0);
      }

      if (!this.form.title) {
        this.$set(this.form, 'title', this.languagesFill(''));
      }

      if (!this.form.width) {
        this.$set(this.form, 'width', 'wide');
      }

      this.activeTab = this.form.activeTab;
      this.$emit('on-changed', this.form);
    },

    methods: {
      onChange() {
        
        if (this.debounceTimer) {
          clearTimeout(this.debounceTimer);
        }
        
        
        this.debounceTimer = setTimeout(() => {
          this.$emit('on-changed', this.form);
        }, 300);
      },

      languagesFill(text) {
        const obj = {};
        $languages.forEach(e => {
          obj[e.code] = text;
        });
        return obj;
      },

      thumbnail(image) {
        if (!image) {
          return PLACEHOLDER_IMAGE;
        }
        if (typeof image === 'string' && image.indexOf('http') === 0) {
          return image;
        }
        if (typeof image === 'object') {
          const locale = $locale || 'zh_cn';
          return image[locale] || (Object.values(image)[0] || PLACEHOLDER_IMAGE);
        }
        return asset + image;
      },

      tabTitleLanguage(titles) {
        return titles['zh_cn'];
      },

      tabsValueProductData(tabIndex) {
        var that = this;
        if (!this.form.screens[tabIndex].products.length) return;
        this.loading = true;

        axios.get('api/panel/products/names?ids=' + this.form.screens[tabIndex].products.map(e => e.id).join(
          ','), {
          hload: true
        }).then((res) => {
          this.loading = false;
          that.productData = res.data;
          this.itemChange(that.productData);
        })
      },

      querySearch(keyword, cb) {
        axios.get('api/panel/products/autocomplete?keyword=' + encodeURIComponent(keyword), null, {
          hload: true
        }).then((res) => {
          cb(res.data);
        })
      },

      handleSelect(item) {
        const currentScreen = this.form.screens[this.activeTab];
        if (!currentScreen.products.find(v => v.id == item.id)) {
          currentScreen.products.push(item);
        }
        this.keyword = "";
      },

      itemChange(evt) {
        this.form.screens[this.activeTab].products = evt;
      },

      removeProduct(index) {
        if (this.form.screens[this.activeTab].products.length <= 1) {
          this.$message.warning('Each screen must retain at least one product.');
          return;
        }
        this.form.screens[this.activeTab].products.splice(index, 1);
      },

      handleTabClick(tab) {
        this.activeTab = tab.index;
        this.form.activeTab = tab.index;
        this.tabsValueProductData(tab.index);
      },

      addScreen() {
        this.form.screens.push({
          products: []
        });
        this.activeTab = this.form.screens.length - 1;
      },

      removeScreen() {
        if (this.form.screens.length <= 1) {
          this.$message.warning('At least one screen must be retained.');
          return;
        }
        this.form.screens.splice(this.activeTab, 1);
        this.activeTab = Math.min(this.activeTab, this.form.screens.length - 1);
      }
    }
  });
</script>
