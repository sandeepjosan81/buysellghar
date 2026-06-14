{{-- Left and right image/text editing modules - Modern UI style --}}
<template id="module-editor-left-image-right-text-template">
  <div class="left-image-right-text-editor">
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

    {{-- Basic Settings --}}
    <div class="editor-section">
      <div class="section-title">
        <i class="el-icon-setting"></i>
        Basic Settings
      </div>
      <div class="section-content">
        <div class="setting-group">
          <div class="setting-label">Image Position</div>
          <div class="option-buttons">
            <div 
              :class="['option-btn', { active: form.image_position === 'left' }]" 
              @click="form.image_position = 'left'"
            >
              <div class="preview-container">
                <div class="preview-image"></div>
                <div class="preview-text"></div>
              </div>
              <span>Left Image, Right Text</span>
            </div>
            <div 
              :class="['option-btn', { active: form.image_position === 'right' }]" 
              @click="form.image_position = 'right'"
            >
              <div class="preview-container">
                <div class="preview-text"></div>
                <div class="preview-image"></div>
              </div>
              <span>Right Image, Left Text</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- Content Settings --}}
    <div class="editor-section">
      <div class="section-title">
        <i class="el-icon-edit"></i>
        Content Settings
      </div>
      <div class="section-content">
        <div class="setting-group">
          <div class="setting-label">Module Title</div>
          <text-i18n v-model="form.title" placeholder="Please enter module title"></text-i18n>
        </div>
        
        <div class="setting-group">
          <div class="setting-label">Subtitle</div>
          <text-i18n v-model="form.subtitle" placeholder="Please enter subtitle"></text-i18n>
        </div>
        
        <div class="setting-group">
          <div class="setting-label">Description</div>
          <text-i18n v-model="form.description" placeholder="Please enter description"></text-i18n>
        </div>
        
        <div class="setting-group">
          <div class="setting-label">Text Alignment</div>
          <div class="option-buttons">
            <div 
              :class="['option-btn', { active: form.text_align === 'left' }]" 
              @click="form.text_align = 'left'"
            >
              <i class="el-icon-s-fold"></i>
              <span>On the left</span>
            </div>
            <div 
              :class="['option-btn', { active: form.text_align === 'center' }]" 
              @click="form.text_align = 'center'"
            >
              <i class="el-icon-s-operation"></i>
              <span>Center</span>
            </div>
            <div 
              :class="['option-btn', { active: form.text_align === 'end' }]" 
              @click="form.text_align = 'end'"
            >
              <i class="el-icon-s-unfold"></i>
              <span>On the right</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- Margin Settings --}}
    <div class="editor-section">
      <div class="section-title">
        <i class="el-icon-position"></i>
        Margin Settings
      </div>
      <div class="section-content">
        <div class="setting-group">
          <div class="setting-label">Overall Margin</div>
          <div class="control-group">
            <div class="control-row">
              <div class="control-item">
                <div class="control-label">Left Margin</div>
                <el-input-number 
                  v-model="form.content_margin_left" 
                  :min="0" 
                  :max="100"
                  size="small"
                  controls-position="right"
                ></el-input-number>
                <span class="control-unit">px</span>
              </div>
              <div class="control-item">
                <div class="control-label">Right Margin</div>
                <el-input-number 
                  v-model="form.content_margin_right" 
                  :min="0" 
                  :max="100"
                  size="small"
                  controls-position="right"
                ></el-input-number>
                <span class="control-unit">px</span>
              </div>
            </div>
            <div class="control-row">
              <div class="control-item">
                <div class="control-label">Top Margin</div>
                <el-input-number 
                  v-model="form.content_margin_top" 
                  :min="0" 
                  :max="100"
                  size="small"
                  controls-position="right"
                ></el-input-number>
                <span class="control-unit">px</span>
              </div>
              <div class="control-item">
                <div class="control-label">Bottom Margin</div>
                <el-input-number 
                  v-model="form.content_margin_bottom" 
                  :min="0" 
                  :max="100"
                  size="small"
                  controls-position="right"
                ></el-input-number>
                <span class="control-unit">px</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- Content Spacing --}}
    <div class="editor-section">
      <div class="section-title">
        <i class="el-icon-s-grid"></i>
        Content Spacing
      </div>
      <div class="section-content">
        <div class="setting-group">
          <div class="control-group">
            <div class="control-item">
              <div class="control-label">Title Spacing</div>
              <el-input-number 
                v-model="form.title_spacing" 
                :min="0" 
                :max="50"
                size="small"
                controls-position="right"
              ></el-input-number>
              <span class="control-unit">px</span>
            </div>
            <div class="control-item">
              <div class="control-label">Subtitle Spacing</div>
              <el-input-number 
                v-model="form.subtitle_spacing" 
                :min="0" 
                :max="50"
                size="small"
                controls-position="right"
              ></el-input-number>
              <span class="control-unit">px</span>
            </div>
            <div class="control-item">
              <div class="control-label">Description Spacing</div>
              <el-input-number 
                v-model="form.description_spacing" 
                :min="0" 
                :max="50"
                size="small"
                controls-position="right"
              ></el-input-number>
              <span class="control-unit">px</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- Image Settings --}}
    <div class="editor-section">
      <div class="section-title">
        <i class="el-icon-picture"></i>
        Image Settings
      </div>
      <div class="section-content">
        <div class="setting-group">
          <div class="setting-label">Image Selection</div>
          <single-image-selector 
            v-model="form.image" 
            :aspectRatio="16 / 9" 
            :targetWidth="800"
            :targetHeight="450"
          ></single-image-selector>
          <div class="setting-tip">
            <i class="el-icon-info"></i>
            Recommended size: 800 x 450, Image aspect ratio 16:9
          </div>
        </div>
        
        <div class="setting-group">
          <div class="setting-label">Image Padding</div>
          <div class="control-group">
            <div class="control-row">
              <div class="control-item">
                <div class="control-label">Horizontal Padding</div>
                <el-input-number 
                  v-model="form.image_padding_x" 
                  :min="0" 
                  :max="100"
                  size="small"
                  controls-position="right"
                ></el-input-number>
                <span class="control-unit">px</span>
              </div>
              <div class="control-item">
                <div class="control-label">Vertical Padding</div>
                <el-input-number 
                  v-model="form.image_padding_y" 
                  :min="0" 
                  :max="100"
                  size="small"
                  controls-position="right"
                ></el-input-number>
                <span class="control-unit">px</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- Button Settings --}}
    <div class="editor-section">
      <div class="section-title">
        <i class="el-icon-link"></i>
        Button Settings
      </div>
      <div class="section-content">
        <div class="setting-group">
          <div class="setting-label">Button Text</div>
          <text-i18n v-model="form.button_text" placeholder="Please enter button text"></text-i18n>
        </div>
        
        <div class="setting-group">
          <div class="setting-label">Button Link</div>
          <link-selector 
            :hide-types="['catalog', 'static']" 
            v-model="form.link"
          ></link-selector>
        </div>
      </div>
    </div>
  </div>
</template>

<style>
/* Left and right image/text editor specific styles - only retain truly specific styles */
.left-image-right-text-editor {
  padding: 0;
  background: #fff;
}

/* Layout options specific styles - restore preview effect */
.option-btn .preview-container {
  display: flex;
  align-items: center;
  gap: 8px;
  margin-bottom: 8px;
  height: 24px;
  width: 100%;
}

.option-btn .preview-image {
  width: 16px;
  height: 16px;
  background: #667eea;
  border-radius: 2px;
  flex-shrink: 0;
}

.option-btn .preview-text {
  flex: 1;
  height: 8px;
  background: #dee2e6;
  border-radius: 4px;
}
</style>

<script type="text/javascript">
  Vue.component('module-editor-left-image-right-text', {
    template: '#module-editor-left-image-right-text-template',
    props: ['module'],
    data: function() {
      return {
        form: {
          image_position: 'left',
          title: '',
          subtitle: '',
          description: '',
          image: '',
          button_text: '',
          text_align: 'left',
          width: 'wide',
          content_margin_left: 0,
          content_margin_right: 0,
          content_margin_top: 0,
          content_margin_bottom: 0,
          title_spacing: 20,
          subtitle_spacing: 15,
          description_spacing: 20,
          image_padding_x: 0,
          image_padding_y: 0,
          link: {
            type: 'category',
            value: '',
            new_window: true
          }
        },
        source: {
          locale: $locale
        }
      }
    },
    created() {
      if (this.module && Object.keys(this.module).length) {
        this.form = Object.assign({}, this.form, this.module);
      }
      
      // Ensure width has a default value
      if (!this.form.width) {
        this.$set(this.form, 'width', 'wide');
      }
    },
    watch: {
      form: {
        handler: function(val) {
          this.$emit('on-changed', val);
        },
        deep: true
      }
    }
  });
</script>
