{{-- Category Products Editor Module --}}
<template id="module-editor-category-products-template">
  <div class="editor-container">
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
            :class="['segmented-btn', { active: form.width === 'narrow' }]" 
            @click="form.width = 'narrow'"
          >
            <i class="el-icon-copy-document"></i>
            Narrow
          </div>
          <div 
            :class="['segmented-btn', { active: form.width === 'wide' }]" 
            @click="form.width = 'wide'"
          >
            <i class="el-icon-copy-document"></i>
            Wide
          </div>
          <div 
            :class="['segmented-btn', { active: form.width === 'full' }]" 
            @click="form.width = 'full'"
          >
            <i class="el-icon-full-screen"></i>
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
        <text-i18n v-model="form.title"></text-i18n>
      </div>
    </div>

    {{-- Display Settings --}}
    <div class="editor-section">
      <div class="section-title">
        <i class="el-icon-setting"></i>
        Display Settings
      </div>
      <div class="section-content">
        
        {{-- Items per Row --}}
        <div class="setting-group">
          <div class="setting-label">Items per Row</div>
          <div class="segmented-buttons">
            <div 
              :class="['segmented-btn', { active: form.columns === 3 }]" 
              @click="form.columns = 3"
            >
              <i class="el-icon-grid"></i>
              3 items
            </div>
            <div 
              :class="['segmented-btn', { active: form.columns === 4 }]" 
              @click="form.columns = 4"
            >
              <i class="el-icon-grid"></i>
              4 items
            </div>
            <div 
              :class="['segmented-btn', { active: form.columns === 6 }]" 
              @click="form.columns = 6"
            >
              <i class="el-icon-grid"></i>
              6 items
            </div>
          </div>
        </div>

        {{-- Product Limit --}}
        <div class="setting-group">
          <div class="setting-label">Number of Products</div>
          <el-input 
            v-model="form.limit" 
            type="number" 
            size="small" 
            placeholder="Enter product quantity"
            @input="limitChange"
            style="width: 100%;"
          ></el-input>
        </div>
      </div>
    </div>

    {{-- Category Settings --}}
    <div class="editor-section">
      <div class="section-title">
        <i class="el-icon-folder"></i>
        Category Settings
      </div>
      <div class="section-content">
        
        {{-- Current Category --}}
        <div class="setting-group" v-if="form.category_name">
          <div class="setting-label">Current Category</div>
          <div class="selected-category">
            <div class="category-info">
              <i class="el-icon-folder"></i>
              <span class="category-name">${ form.category_name }</span>
            </div>
            <el-button 
              type="text" 
              size="mini" 
              @click="clearCategory"
              style="color: #f56c6c;"
            >
              <i class="el-icon-delete"></i>
              Clear
            </el-button>
          </div>
        </div>

        {{-- Search Category --}}
        <div class="setting-group">
          <div class="setting-label">Search Category</div>
          <div class="autocomplete-group-wrapper">
            <el-autocomplete 
              class="inline-input" 
              v-model="keyword" 
              value-key="name" 
              size="small"
              :fetch-suggestions="querySearch" 
              placeholder="Enter keywords to search categories" 
              :highlight-first-item="true"
              @select="handleSelect"
              style="width: 100%;"
            ></el-autocomplete>
          </div>
        </div>

        {{-- Sorting --}}
        <div class="setting-group">
          <div class="setting-label">Sort By</div>
          <el-select v-model="form.sort" size="small" style="width: 100%;" @change="onSortChange">
            <el-option label="Best Selling" value="sales_desc"></el-option>
            <el-option label="Price: High to Low" value="price_desc"></el-option>
            <el-option label="Price: Low to High" value="price_asc"></el-option>
            <el-option label="Newest" value="created_desc"></el-option>
            <el-option label="Top Rated" value="rating_desc"></el-option>
            <el-option label="Most Viewed" value="viewed_desc"></el-option>
            <el-option label="Recently Updated" value="updated_desc"></el-option>
            <el-option label="Recommended" value="position_asc"></el-option>
          </el-select>
        </div>
      </div>
    </div>
  </div>
</template>
<script type="text/javascript">
  Vue.component('module-editor-category-products', {
    delimiters: ['${', '}'],
    template: '#module-editor-category-products-template',
    props: ['module'],
    data: function() {
      return {
        keyword: '',
        form: null
      }
    },

    watch: {
      form: {
        handler: function(val) {
          this.$emit('on-changed', val);
        },
        deep: true
      }
    },

    created: function() {
      this.form = JSON.parse(JSON.stringify(this.module));
      if (!this.form.width) {
        this.$set(this.form, 'width', 'wide');
      }
      if (!this.form.columns) {
        this.$set(this.form, 'columns', 4);
      }
      if (!this.form.sort) {
        this.$set(this.form, 'sort', 'sales_desc');
      }

     
      if (this.form.category_name) {
        this.keyword = this.form.category_name;
      }
    },

    computed: {},

    methods: {
      querySearch(keyword, cb) {
        let url = 'api/panel/categories/autocomplete';
        if (keyword && keyword.length > 0) {
          url += '?keyword=' + encodeURIComponent(keyword);
        }
        
        axios.get(url, {
          hload: true
        }).then((res) => {
          cb(res.data || []);
        }).catch(() => {
          cb([]);
        });
      },

      handleSelect(item) {     
        this.form.category_id = item.id;
        this.form.category_name = item.name;
        this.keyword = item.name;      
        this.$emit('on-changed', this.form);
      },

      clearCategory() {
        this.form.category_id = '';
        this.form.category_name = '';
        this.keyword = '';
        this.$emit('on-changed', this.form);
      },

      onSortChange() {        
        this.$emit('on-changed', this.form);
      },

      limitChange(e) {
        this.form.limit = e;        
        this.$emit('on-changed', this.form);
      },


    }
  });
</script> 