{{-- Image and text list editing module - Modern style --}}
<template id="module-editor-image-text-list-template">
  <div class="image-text-list-editor">
    <div class="top-spacing"></div>
    
    {{-- Module width settings --}}
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
            Full
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
          placeholder="Please enter the module title"
        ></text-i18n>
      </div>
    </div>

    {{-- Display Settings --}}
    <div class="editor-section">
      <div class="section-title">
        <i class="el-icon-setting"></i>
        Display Settings
      </div>
      <div class="section-content">
        {{-- Number of rows displayed per line --}}
        <div class="setting-group">
          <div class="setting-label">Display quantity per line</div>
          <div class="segmented-buttons">
            <div 
              :class="['segmented-btn', { active: module.columns === 3 }]" 
              @click="setColumns(3)"
            >
              3个
            </div>
            <div 
              :class="['segmented-btn', { active: module.columns === 4 }]" 
              @click="setColumns(4)"
            >
              4个
            </div>
            <div 
              :class="['segmented-btn', { active: module.columns === 5 }]" 
              @click="setColumns(5)"
            >
              5个
            </div>
            <div 
              :class="['segmented-btn', { active: module.columns === 6 }]" 
              @click="setColumns(6)"
            >
              6个
            </div>
          </div>
        </div>

        {{-- Automatic carousel settings --}}
        <div class="setting-group">
          <div class="setting-label">Automatic carousel</div>
          <div class="switch-wrapper">
            <el-switch 
              v-model="module.autoplay" 
              @change="onChange"
              active-text="Enable" 
              inactive-text="Disable"
              size="small"
            ></el-switch>
          </div>
        </div>

        {{-- Carousel interval time --}}
        <div class="setting-group" v-if="module.autoplay">
          <div class="setting-label">Carousel interval time</div>
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
            Unit: milliseconds, recommended setting 3000-5000
          </div>
        </div>

        {{-- show title --}}
        <div class="setting-group">
          <div class="setting-label">show title</div>
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

        {{-- Image height settings --}}
        <div class="setting-group">
          <div class="setting-label">Image height</div>
          <el-input-number 
            v-model="module.itemHeight" 
            @change="onChange"
            :min="60" 
            :max="300" 
            :step="10"
            size="small"
            style="width: 100%;"
          ></el-input-number>
          <div class="setting-tip">
            <i class="el-icon-info"></i>
            Unit: pixels, recommended setting 80-200
          </div>
        </div>

        {{-- Internal padding settings --}}
        <div class="setting-group">
          <div class="setting-label">Internal padding</div>
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
            Unit: pixels, 0 means no inner margin, controlling the spacing between images and text and the card edges.
          </div>
        </div>

        {{-- Border rounded corners --}}
        <div class="setting-group">
          <div class="setting-label">Border radius</div>
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
            Unit: pixels, 0 represents a right angle, recommended setting is 4-16.
          </div>
        </div>

        {{-- Border width --}}
        <div class="setting-group">
          <div class="setting-label">Border width</div>
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
            Unit: pixels, 0 indicates no border.
          </div>
        </div>

        {{-- Border color --}}
        <div class="setting-group">
          <div class="setting-label">Border color</div>
          <el-color-picker 
            v-model="module.borderColor" 
            @change="onChange"
            size="small"
            style="width: 100%;"
            show-alpha
          ></el-color-picker>
        </div>

        {{-- Border style --}}
        <div class="setting-group">
          <div class="setting-label">Border style</div>
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

    {{-- Image-Text Item Management --}}
    <div class="editor-section">
      <div class="section-title">
        <i class="el-icon-picture"></i>
        Image-Text Item Management
      </div>
      <div class="section-content">
        {{-- Image-Text Item List --}}
        <div class="image-text-list" v-loading="loading">
          <template v-if="module.imageTextItems && module.imageTextItems.length">
            <draggable 
              ghost-class="dragabble-ghost" 
              :list="module.imageTextItems" 
              @change="onChange"
              :options="{ animation: 330 }"
              class="image-text-draggable"
            >
                             <div v-for="(item, index) in module.imageTextItems" :key="index" class="image-text-item">
                 <div class="item-preview">
                   <img 
                     :src="getImageUrl(item.image)" 
                     :alt="item.name"
                     class="preview-img"
                   >
                 </div>
                 <div class="item-info">
                   <div class="item-name">@{{ item.name }}</div>
                   <div class="item-link" v-if="item.link && item.link.value && item.link.type">
                     <i class="el-icon-link"></i>
                     @{{ getLinkDisplayText(item.link) }}
                   </div>
                 </div>
                 <div class="item-actions">
                   <el-button 
                     type="primary" 
                     size="mini" 
                     icon="el-icon-edit" 
                     @click="editItem(index)"
                     style="padding: 6px; min-width: 28px;"
                   ></el-button>
                   <el-button 
                     type="danger" 
                     size="mini" 
                     icon="el-icon-delete" 
                     @click="removeItem(index)"
                     style="padding: 6px; min-width: 28px;"
                   ></el-button>
                 </div>
               </div>
            </draggable>
          </template>
          
          {{-- Empty state --}}
          <div v-else class="empty-state">
            <i class="el-icon-picture-outline"></i>
            <p>No image or text item available.</p>
            <span>Click the button below to add an image-text item</span>
          </div>
        </div>

        {{-- Add Image and Text Item Button --}}
        <div class="add-item-section">
          <el-button 
            type="primary" 
            icon="el-icon-plus" 
            @click="addItem"
            size="small"
            style="width: 100%;"
          >
            Add image and text items
          </el-button>
        </div>
      </div>
    </div>

    {{-- Image and text item editing dialog box --}}
    <el-dialog 
      :title="editingItemIndex === -1 ? 'Add image and text items' : 'Edit image and text item'" 
      :visible.sync="showItemDialog" 
      width="500px"
      @close="closeItemDialog"
    >
      <div class="item-form">
        {{-- title --}}
        <div class="form-group">
          <label>title</label>
          <el-input 
            v-model="editingItem.name" 
            placeholder="Please enter a title"
            size="small"
          ></el-input>
        </div>

        {{-- 图片 --}}
        <div class="form-group">
          <label>picture</label>
          <single-image-selector 
            v-model="editingItem.image" 
            :aspectRatio="2/1" 
            :targetWidth="200"
            :targetHeight="100"
          ></single-image-selector>
          <div class="form-tip">
            <i class="el-icon-info"></i>
            Suggested size: 200 x 100 (2:1 ratio)
          </div>
        </div>

        {{-- Link --}}
        <div class="form-group">
          <label>Link (optional)</label>
          <link-selector 
            v-model="editingItem.link" 
            placeholder="Please select or enter a link"
            :is-title="false"
          ></link-selector>
          <div class="form-tip" v-if="editingItem.link && editingItem.link.value">
            <i class="el-icon-info"></i>
            Current link: @{{ getLinkDisplayText(editingItem.link) }}
          </div>
        </div>
      </div>
      
      <div slot="footer" class="dialog-footer">
        <el-button @click="closeItemDialog">Cancel</el-button>
        <el-button type="primary" @click="saveItem">Save</el-button>
      </div>
    </el-dialog>
  </div>
</template>

{{-- Image and text list editor module script --}}
<script type="text/javascript">
  Vue.component('module-editor-image-text-list', {
    template: '#module-editor-image-text-list-template',
    props: ['module'],
    
    data: function() {
      return {
        debounceTimer: null,
        loading: false,
        showItemDialog: false,
        editingItemIndex: -1,
        editingItem: {
          name: '',
          image: '',
          link: {
            type: 'url',
            value: ''
          }
        },
        source: {
          locale: $locale
        }
      }
    },

    watch: {
      module: {
        handler: function(val) {
          this.onChange();
        },
        deep: true,
      }
    },

    created: function() {
      // 
        if (!this.module.title) {
          this.$set(this.module, 'title', this.languagesFill('Picture and text list'));
        }
      if (!this.module.imageTextItems) {
        this.$set(this.module, 'imageTextItems', []);
      }
      if (!this.module.columns) {
        this.$set(this.module, 'columns', 4);
      }
      if (!this.module.autoplay) {
        this.$set(this.module, 'autoplay', false);
      }
      if (!this.module.autoplaySpeed) {
        this.$set(this.module, 'autoplaySpeed', 3000);
      }
      if (!this.module.showNames) {
        this.$set(this.module, 'showNames', true);
      }
      if (!this.module.width) {
        this.$set(this.module, 'width', 'wide');
      }
      if (!this.module.itemHeight) {
        this.$set(this.module, 'itemHeight', 120);
      }
      if (!this.module.padding) {
        this.$set(this.module, 'padding', 16);
      }
      if (!this.module.borderRadius) {
        this.$set(this.module, 'borderRadius', 8);
      }
      if (!this.module.borderWidth) {
        this.$set(this.module, 'borderWidth', 1);
      }
      if (!this.module.borderColor) {
        this.$set(this.module, 'borderColor', '#f0f0f0');
      }
      if (!this.module.borderStyle) {
        this.$set(this.module, 'borderStyle', 'solid');
      }
    },

    methods: {
      onChange() {
        // 
        if (this.debounceTimer) {
          clearTimeout(this.debounceTimer);
        }
        
        // 
        this.debounceTimer = setTimeout(() => {
          this.$emit('on-changed', this.module);
        }, 300);
      },

      setModuleWidth(width) {
        this.$set(this.module, 'width', width);
        this.onChange();
      },

      setColumns(columns) {
        this.$set(this.module, 'columns', columns);
        this.onChange();
      },

      getImageUrl(image) {
        if (!image) {
          return PLACEHOLDER_IMAGE;
        }
        if (typeof image === 'string' && image.indexOf('http') === 0) {
          return image;
        }
        if (typeof image === 'object') {
          const locale = this.source.locale;
          return image[locale] || (Object.values(image)[0] || PLACEHOLDER_IMAGE);
        }
        return asset + image;
      },

      addItem() {
        this.editingItemIndex = -1;
        this.editingItem = {
          name: '',
          image: '',
          link: {
            type: 'url',
            value: ''
          }
        };
        this.showItemDialog = true;
      },

      editItem(index) {
        this.editingItemIndex = index;
        this.editingItem = JSON.parse(JSON.stringify(this.module.imageTextItems[index]));
        this.showItemDialog = true;
      },

      removeItem(index) {
        this.$confirm('Are you sure you want to delete this image and text item?', 'hint', {
          confirmButtonText: 'Confirm',
          cancelButtonText: 'Cancel',
          type: 'warning'
        }).then(() => {
          this.module.imageTextItems.splice(index, 1);
          this.onChange();
          this.$message.success('Delete successful');
        }).catch(() => {
          // 
        });
      },

      saveItem() {
        if (!this.editingItem.name.trim()) {
          this.$message.error('Please enter a title');
          return;
        }
        if (!this.editingItem.image) {
          this.$message.error('Please select an image');
          return;
        }

        if (this.editingItemIndex === -1) {
          // 添加新图文项
          this.module.imageTextItems.push(JSON.parse(JSON.stringify(this.editingItem)));
        } else {
          // 编辑现有图文项
          this.$set(this.module.imageTextItems, this.editingItemIndex, JSON.parse(JSON.stringify(this.editingItem)));
        }

        this.onChange();
        this.closeItemDialog();
        this.$message.success(this.editingItemIndex === -1 ? 'Add successful' : 'Update successful');
      },

      closeItemDialog() {
        this.showItemDialog = false;
        this.editingItemIndex = -1;
        this.editingItem = {
          name: '',
          image: '',
          link: {
            type: 'url',
            value: ''
          }
        };
      },

      languagesFill(text) {
        const obj = {};
        $languages.forEach(e => {
          obj[e.code] = text;
        });
        return obj;
      },

      getLinkDisplayText(link) {
        if (!link || !link.type) {
          return '';
        }

        switch (link.type) {
          case 'custom':
            return link.value || 'Custom Link';
          case 'static':
            const staticLinks = {
              'account.index': 'Personal Center',
              'account.wishlist.index': 'My Wishlist',
              'account.order.index': 'My Orders',
              'brands.index': 'Brand List'
            };
            return staticLinks[link.value] || link.value;
          case 'product':
            return link.value ? `Product #${link.value}` : 'Product Link';
          case 'category':
            return link.value ? `Category #${link.value}` : 'Product Category';
          case 'page':
            return link.value ? `Page #${link.value}` : 'Page Link';
          case 'catalog':
            return link.value ? `Article classification #${link.value}` : 'Article classification';
          case 'brand':
            return link.value ? `Brand #${link.value}` : 'Brand Link';
          default:
            return link.value || 'Unknown Link';
        }
      }
    }
  });
</script> 