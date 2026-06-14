{{-- Multi-line image layout editing module --}}
<template id="module-editor-multi-row-images-template">
  <div class="editor-container">
    <div class="top-spacing"></div>
    
    {{-- Module Width Settings --}}
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
            Full Screen
          </div>
        </div>
      </div>
    </div>

    {{-- Module Title --}}
    <div class="editor-section">
      <div class="section-title">Module Title</div>
      <div class="section-content">
        <text-i18n v-model="form.title" @change="onChange" placeholder="Please enter module title"></text-i18n>
      </div>
    </div>

    {{-- Subtitle --}}
    <div class="editor-section">
      <div class="section-title">Subtitle</div>
      <div class="section-content">
        <text-i18n v-model="form.subtitle" @change="onChange" placeholder="Please enter subtitle"></text-i18n>
      </div>
    </div>

    {{-- Image Settings --}}
    <div class="editor-section">
      <div class="section-title">Image Settings</div>
      <div class="section-content">
        <div class="setting-tip">
          <i class="el-icon-info"></i>
         We recommend uploading images of the same size, and you can drag and drop to sort them.
        </div>
        
        <div class="row-manager">
          <div class="row-list">
            <div class="row-item" v-for="(row, rowIndex) in form.rows" :key="rowIndex">
              <div class="row-header">
                <div class="row-info">
                  <span class="row-title">No. @{{ rowIndex + 1 }} Row</span>
                  <el-select v-model="row.count" placeholder="Images per row" size="small" @change="onChange">
                    <el-option label="3 images per row" :value="3"></el-option>
                    <el-option label="4 images per row" :value="4"></el-option>
                    <el-option label="6 images per row" :value="6"></el-option>
                  </el-select>
                </div>
                <div class="row-actions">
                  <el-button type="text" @click="row.collapsed = !row.collapsed" size="small">
                    <i :class="row.collapsed ? 'el-icon-arrow-down' : 'el-icon-arrow-up'"></i>
                    @{{ row.collapsed ? 'Expand' : 'Collapse' }}
                  </el-button>
                  <el-button type="text" @click="removeRow(rowIndex)" icon="el-icon-delete" size="small"></el-button>
                </div>
              </div>
              
              <div v-show="!row.collapsed" class="image-list">
                <template v-if="row.images && row.images.length > 0">
                  <div class="image-item" v-for="(item, index) in row.images" :key="index">
                    <div class="image-preview">
                      <img :src="thumbnail(item.image)" class="preview-img">
                      <div class="image-actions">
                        <el-button type="text" @click="removeImage(rowIndex, index)" icon="el-icon-delete" size="mini"></el-button>
                      </div>
                    </div>

                    <div class="image-details">
                      <div class="setting-group">
                        <div class="setting-label">Image Description</div>
                        <text-i18n v-model="item.description" @change="onChange" placeholder="Please enter image description"></text-i18n>
                      </div>
                      
                      <div class="setting-group">
                        <div class="setting-label">Image Link</div>
                        <link-selector :hide-types="['catalog', 'static']" v-model="item.link" @change="onChange"></link-selector>
                      </div>
                      
                      <div class="setting-group">
                        <div class="setting-label">Select Image</div>
                        <single-image-selector v-model="item.image" :aspectRatio="1" :targetWidth="400"
                          :targetHeight="400" @change="onChange"></single-image-selector>
                        <div class="upload-tip">Recommended Size: 400 x 400, Image Ratio 1:1</div>
                      </div>
                      
                      <div class="setting-group">
                        <div class="setting-label">Description Background Color</div>
                        <input type="color" v-model="item.descBgColor" @change="onChange" style="width: 40px; height: 24px; border: none; border-radius: 4px;">
                      </div>
                      
                      <div class="setting-group">
                        <div class="setting-label">Description Text Color</div>
                        <input type="color" v-model="item.descTextColor" @change="onChange" style="width: 40px; height: 24px; border: none; border-radius: 4px;">
                      </div>
                      
                                              <div class="setting-group">
                          <div class="setting-label">Description Text Size</div>
                          <el-input-number v-model="item.descFontSize" :min="10" :max="32" size="small" @change="onChange" style="width: 100%;"></el-input-number>
                          <div class="setting-tip">
                            <i class="el-icon-info"></i>
                            Unit: Pixels, Recommended: 12-24
                          </div>
                        </div>
                    </div>
                  </div>
                </template>
                
                <div v-else class="empty-state">
                  <i class="el-icon-picture-outline"></i>
                  <p>No images available, please click the button below to add</p>
                </div>

                <div class="add-image" v-if="!row.images || row.images.length < row.count">
                  <el-button type="primary" size="small" @click="addImage(rowIndex)" icon="el-icon-circle-plus-outline">
                    Add Image (@{{ row.images ? row.images.length : 0 }}/@{{ row.count }})
                  </el-button>
                </div>
              </div>
            </div>
          </div>

          <div class="add-row">
            <el-button type="primary" size="small" @click="addRow()" icon="el-icon-circle-plus-outline">
              Add New Row
            </el-button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

{{-- Multi-line image layout component script --}}
<script type="text/javascript">
  Vue.component('module-editor-multi-row-images', {
    template: '#module-editor-multi-row-images-template',
    props: ['module'],
    data: function() {
      return {
        debounceTimer: null,
        form: {
          title: {},
          subtitle: {},
          width: 'wide',
          rows: []
        },
        source: {
          locale: $locale
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

    created() {
      if (this.module) {
        this.form = JSON.parse(JSON.stringify(this.module));
      }

      if (!this.form.title) {
        this.$set(this.form, 'title', this.languagesFill(''));
      }

      if (!this.form.subtitle) {
        this.$set(this.form, 'subtitle', this.languagesFill(''));
      }

      if (!this.form.rows || this.form.rows.length === 0) {
        this.$set(this.form, 'rows', [{
          count: 3,
          images: [],
          collapsed: false
        }]);
      } else {
        // 
        this.form.rows.forEach(row => {
          if (!row.images || !Array.isArray(row.images)) {
            this.$set(row, 'images', []);
          }
        });
      }

      if (!this.form.width) {
        this.$set(this.form, 'width', 'wide');
      }

      this.$emit('on-changed', this.form);
    },

    methods: {
      onChange() {
        // 
        if (this.debounceTimer) {
          clearTimeout(this.debounceTimer);
        }
        
        // 
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
          return PLACEHOLDER_IMAGE_URL;
        }
        if (typeof image === 'string' && image.indexOf('http') === 0) {
          return image;
        }
        if (typeof image === 'object') {
          const locale = $locale || 'zh_cn';
          return image[locale] || (Object.values(image)[0] || PLACEHOLDER_IMAGE_URL);
        }
        return asset + image;
      },
      
      addRow() {
        this.form.rows.push({
          count: 3,
          images: [],
          collapsed: false
        });
      },
      removeRow(index) {
        this.form.rows.splice(index, 1);
      },
      addImage(rowIndex) {
        const row = this.form.rows[rowIndex];
        if (row.images.length >= row.count) {
          this.$message.warning('This row can only add a maximum of ' + row.count + ' entries.');
          return;
        }
        row.images.push({
          image: '',
          description: this.languagesFill(''),
          link: {
            type: 'product',
            value: ''
          },
          descBgColor: 'rgba(255,255,255,0.75)',
          descTextColor: '#222',
          descFontSize: 14
        });
      },
      removeImage(rowIndex, index) {
        this.form.rows[rowIndex].images.splice(index, 1);
      }
    }
  });
</script>

<style>
  /* multi-row-images 编辑器特定样式 */
  
  .row-manager {
    margin-top: 12px;
  }

  .row-item {
    background: #f8f9fa;
    border: 1px solid #e9ecef;
    border-radius: 6px;
    margin-bottom: 12px;
    padding: 12px;
    transition: all 0.3s ease;
  }

  .row-item:hover {
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  }

  .row-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 0;
    border-bottom: 1px solid #e9ecef;
    margin-bottom: 12px;
  }

  .row-info {
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .row-title {
    font-weight: 500;
    color: #333;
    font-size: 13px;
  }

  .row-actions {
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .image-list {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    margin-top: 12px;
  }

  .image-item {
    height: 600px;
    background: #fff;
    border: 1px solid #e9ecef;
    border-radius: 6px;
    padding: 12px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
  }

  .image-item:hover {
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
  }

  .image-preview {
    position: relative;
    margin-bottom: 12px;
  }

  .preview-img {
    width: 100%;
    height: 120px;
    object-fit: cover;
    border-radius: 4px;
    border: 1px solid #dee2e6;
  }

  .image-actions {
    position: absolute;
    top: 4px;
    right: 4px;
    background: rgba(0, 0, 0, 0.6);
    border-radius: 4px;
    padding: 2px;
  }

  .image-details {
    border-top: 1px solid #e9ecef;
    padding-top: 12px;
  }

  .add-image,
  .add-row {
    text-align: center;
    margin-top: 12px;
    padding: 16px;
    border: 2px dashed #dee2e6;
    border-radius: 6px;
    background: #f8f9fa;
    transition: all 0.3s ease;
  }

  .add-image:hover,
  .add-row:hover {
    border-color: #667eea;
    background: #f0f4ff;
  }

  .empty-state {
    text-align: center;
    padding: 40px 20px;
    color: #999;
    background: #f8f9fa;
    border: 2px dashed #dee2e6;
    border-radius: 6px;
    margin: 12px 0;
  }

  .empty-state i {
    font-size: 48px;
    color: #ccc;
    margin-bottom: 12px;
    display: block;
  }

  .empty-state p {
    margin: 0;
    font-size: 14px;
    color: #666;
  }
</style>
