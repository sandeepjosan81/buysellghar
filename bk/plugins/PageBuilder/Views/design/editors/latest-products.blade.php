{{-- Latest Product Editing Module --}}
<template id="module-editor-latest-products-template">
  <div class="editor-container">
    <div class="top-spacing"></div>
    
    {{-- Module Width Settings --}}
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
            Full Screen
          </div>
        </div>
      </div>
    </div>

    {{-- Module Title Settings --}}
    <div class="editor-section">
      <div class="section-title">
        <i class="el-icon-edit"></i>
        Module Title
      </div>
      <div class="section-content">
        <text-i18n v-model="form.title" @change="onChange" placeholder="Please enter module title"></text-i18n>
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
              3个
            </div>
            <div 
              :class="['segmented-btn', { active: form.columns === 4 }]" 
              @click="form.columns = 4"
            >
              <i class="el-icon-grid"></i>
              4个
            </div>
            <div 
              :class="['segmented-btn', { active: form.columns === 6 }]" 
              @click="form.columns = 6"
            >
              <i class="el-icon-grid"></i>
              6个
            </div>
          </div>
        </div>

        {{-- Item Limit --}}
        <div class="setting-group">
          <div class="setting-label">Item Limit</div>
          <el-input 
            v-model="form.limit" 
            type="number" 
            size="small" 
            placeholder="Please enter item limit"
            style="width: 100%;"
          ></el-input>
          <div class="setting-tip">
            <i class="el-icon-info"></i>
            Displays the number of newly added products.
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

{{-- Latest Products Editor Module Script --}}
<script type="text/javascript">
  Vue.component('module-editor-latest-products', {
    delimiters: ['${', '}'],
    template: '#module-editor-latest-products-template',
    props: ['module'],
    data: function() {
      return {
        debounceTimer: null,
        form: {
          title: {},
          limit: 8,
          columns: 4,
          width: 'wide'
        }
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

      if (!this.form.title) {
        this.$set(this.form, 'title', this.languagesFill(''));
      }

      if (!this.form.width) {
        this.$set(this.form, 'width', 'wide');
      }

      if (!this.form.columns) {
        this.$set(this.form, 'columns', 4);
      }

      if (!this.form.limit) {
        this.$set(this.form, 'limit', 8);
      }

      this.$emit('on-changed', this.form);
    },

    methods: {
      onChange() {
        // Clear previous timer
        if (this.debounceTimer) {
          clearTimeout(this.debounceTimer);
        }
        
        // Set new debounce timer
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
      }
    }
  });
</script> 