<script type="text/x-template" id="module-editor-brands-template">
  <div class="module-editor">
    <div class="top-spacing"></div>
    
    {{-- Module Width --}}
    <div class="editor-section">
      <div class="section-title">
        <i class="el-icon-monitor"></i>
        Module Width
      </div>
      <div class="section-content">
        <div class="segmented-buttons">
          <div 
            :class="['segmented-btn', { active: module.width === 'narrow' }]" 
            @click="setModuleWidth('narrow')"
          >
            Narrow
          </div>
          <div 
            :class="['segmented-btn', { active: module.width === 'wide' }]" 
            @click="setModuleWidth('wide')"
          >
            Wide
          </div>
          <div 
            :class="['segmented-btn', { active: module.width === 'full' }]" 
            @click="setModuleWidth('full')"
          >
            Full Width
          </div>
        </div>
      </div>
    </div>

    {{-- Module Title --}}
    <div class="editor-section">
      <div class="section-title">
        <i class="el-icon-edit"></i>
        Module Title
      </div>
      <div class="section-content">
        <text-i18n 
          v-model="module.title" 
          @change="onChange" 
          placeholder="Enter module title"
        ></text-i18n>
      </div>
    </div>

    {{-- Content Settings --}}
    <div class="editor-section">
      <div class="section-title">
        <i class="el-icon-picture"></i>
        Content Settings
      </div>
      <div class="section-content">
        <div class="setting-group">
          <div class="setting-label">Select Brand</div>

          <div class="search-section">
            <el-autocomplete 
              class="search-input" 
              v-model="keyword" 
              value-key="name" 
              size="small"
              :fetch-suggestions="querySearch" 
              placeholder="Search brand by keyword" 
              :highlight-first-item="true"
              @select="handleSelect"
              style="width: 100%;"
            ></el-autocomplete>
          </div>

          <div class="products-section">
            <div class="section-subtitle">Selected Brands</div>

            <div class="products-list" v-loading="loading">
              <template v-if="module.brands.length">
                <div v-for="(brand, index) in module.brands" :key="brand.id" class="product-item">
                  <div class="product-info">
                    <div class="product-preview">
                      <img :src="brand.logo_url" :alt="brand.name" class="preview-img">
                    </div>
                    <div class="product-details">
                      <div class="product-name">${brand.name}</div>
                    </div>
                  </div>

                  <div class="product-actions">
                    <el-button 
                      type="danger" 
                      size="mini" 
                      icon="el-icon-delete" 
                      circle
                      @click="removeBrand(index)"
                    ></el-button>
                  </div>
                </div>
              </template>

              <div v-else class="empty-state">
                <i class="el-icon-award"></i>
                <p>No brands available. Please search and add above.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- Style Settings --}}
    <div class="editor-section">
      <div class="section-title">
        <i class="el-icon-brush"></i>
        Style Settings
      </div>
      <div class="section-content">

        {{-- Columns --}}
        <div class="setting-group">
          <div class="setting-label">Columns</div>
          <div class="segmented-buttons">
            <div 
              :class="['segmented-btn', { active: module.columns === 3 }]" 
              @click="setColumns(3)"
            >
              3
            </div>
            <div 
              :class="['segmented-btn', { active: module.columns === 4 }]" 
              @click="setColumns(4)"
            >
              4
            </div>
            <div 
              :class="['segmented-btn', { active: module.columns === 6 }]" 
              @click="setColumns(6)"
            >
              6
            </div>
          </div>
        </div>

        {{-- Autoplay --}}
        <div class="setting-group">
          <div class="setting-label">Autoplay</div>
          <div class="switch-wrapper">
            <el-switch 
              v-model="module.autoplay" 
              @change="onChange"
              active-text="Enabled" 
              inactive-text="Disabled"
              size="small"
            ></el-switch>
          </div>
        </div>

        {{-- Autoplay Speed --}}
        <div class="setting-group" v-if="module.autoplay">
          <div class="setting-label">Autoplay Speed</div>
          <el-input-number 
            v-model="module.autoplaySpeed" 
            @change="onChange"
            :min="1000" 
            :max="10000" 
            :step="500"
            size="small"
            style="width: 100%;"
          ></el-input-number>
          <div class="setting-tip">
            <i class="el-icon-info"></i>
            Unit: milliseconds (Recommended: 3000–5000)
          </div>
        </div>

        {{-- Show Brand Name --}}
        <div class="setting-group">
          <div class="setting-label">Show Brand Name</div>
          <div class="switch-wrapper">
            <el-switch 
              v-model="module.showNames" 
              @change="onChange"
              active-text="Show" 
              inactive-text="Hide"
              size="small"
            ></el-switch>
          </div>
        </div>

        {{-- Image Height --}}
        <div class="setting-group">
          <div class="setting-label">Image Height</div>
          <el-input-number 
            v-model="module.itemHeight" 
            @change="onChange"
            :min="40" 
            :max="200" 
            :step="10"
            size="small"
            style="width: 100%;"
          ></el-input-number>
          <div class="setting-tip">
            <i class="el-icon-info"></i>
            Unit: px (Recommended: 60–120)
          </div>
        </div>

        {{-- Padding --}}
        <div class="setting-group">
          <div class="setting-label">Padding</div>
          <el-input-number 
            v-model="module.padding" 
            @change="onChange"
            :min="0" 
            :max="40" 
            :step="2"
            size="small"
            style="width: 100%;"
          ></el-input-number>
          <div class="setting-tip">
            <i class="el-icon-info"></i>
            Unit: px (0 = no padding)
          </div>
        </div>

        {{-- Border Radius --}}
        <div class="setting-group">
          <div class="setting-label">Border Radius</div>
          <el-input-number 
            v-model="module.borderRadius" 
            @change="onChange"
            :min="0" 
            :max="50" 
            :step="1"
            size="small"
            style="width: 100%;"
          ></el-input-number>
          <div class="setting-tip">
            <i class="el-icon-info"></i>
            Unit: px (Recommended: 4–16)
          </div>
        </div>

        {{-- Border Width --}}
        <div class="setting-group">
          <div class="setting-label">Border Width</div>
          <el-input-number 
            v-model="module.borderWidth" 
            @change="onChange"
            :min="0" 
            :max="10" 
            :step="1"
            size="small"
            style="width: 100%;"
          ></el-input-number>
          <div class="setting-tip">
            <i class="el-icon-info"></i>
            Unit: px (0 = no border)
          </div>
        </div>

        {{-- Border Color --}}
        <div class="setting-group">
          <div class="setting-label">Border Color</div>
          <el-color-picker 
            v-model="module.borderColor" 
            @change="onChange"
            size="small"
            style="width: 100%;"
            show-alpha
          ></el-color-picker>
        </div>

        {{-- Border Style --}}
        <div class="setting-group">
          <div class="setting-label">Border Style</div>
          <el-select 
            v-model="module.borderStyle" 
            @change="onChange"
            size="small"
            style="width: 100%;"
          >
            <el-option label="Solid" value="solid"></el-option>
            <el-option label="Dashed" value="dashed"></el-option>
            <el-option label="Dotted" value="dotted"></el-option>
            <el-option label="Double" value="double"></el-option>
          </el-select>
        </div>

      </div>
    </div>
  </div>
</script>

<style scoped>
.responsive-settings {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.responsive-item {
  display: flex;
  flex-direction: column;
  gap: 6px;
}

.responsive-label {
  font-size: 12px;
  color: #666;
  font-weight: 500;
}
</style>

<script type="text/javascript">
  Vue.component('module-editor-brands', {
    delimiters: ['${', '}'],
    template: '#module-editor-brands-template',
    props: ['module'],
    data: function() {
      return {
        keyword: '',
        loading: false
      }
    },

    watch: {
      module: {
        handler: function(val) {
          this.$emit('on-changed', val);
        },
        deep: true
      }
    },

    created: function() {
      
      if (!this.module.brands) {
        this.$set(this.module, 'brands', []);
      }
      if (!this.module.columns) {
        this.$set(this.module, 'columns', 4); 
      }
      if (!this.module.autoplay) {
        this.$set(this.module, 'autoplay', false);
      }
      if (!this.module.autoplaySpeed) {
        this.$set(this.module, 'autoplaySpeed', 4000); 
      }
      if (!this.module.showNames) {
        this.$set(this.module, 'showNames', true); 
      }
      if (!this.module.itemHeight) {
        this.$set(this.module, 'itemHeight', 100); 
      }
      if (!this.module.padding) {
        this.$set(this.module, 'padding', 0); 
      }
      if (!this.module.borderRadius) {
        this.$set(this.module, 'borderRadius', 12); 
      }
      if (!this.module.borderWidth) {
        this.$set(this.module, 'borderWidth', 0); 
      }
      if (!this.module.borderColor) {
        this.$set(this.module, 'borderColor', '#e8e8e8'); 
      }
      if (!this.module.borderStyle) {
        this.$set(this.module, 'borderStyle', 'solid');
      }

      
      if (!this.module.width) {
        this.$set(this.module, 'width', 'wide'); 
      }
    },

    methods: {
      onChange() {
        this.$emit('on-changed', this.module);
      },

      setColumns(columns) {
        this.module.columns = columns;
        this.onChange();
      },

      setModuleWidth(width) {
        this.module.width = width;
        this.onChange();
      },

      querySearch(keyword, cb) {
        axios.get('api/panel/brands/autocomplete?keyword=' + encodeURIComponent(keyword.trim()))
          .then((res) => {
            cb(res.data || []);
          })
          .catch((error) => {
            cb([]);
          });
      },

      handleSelect(item) {
        
        const exists = this.module.brands.find(b => b.id === item.id);
        if (!exists) {
          this.module.brands.push(item);
          this.onChange();
        }
        this.keyword = '';
      },

      removeBrand(index) {
        this.module.brands.splice(index, 1);
        this.onChange();
      }
    }
  });
</script>

 