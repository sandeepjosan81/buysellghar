{{-- Four-image editing module per line - Modern style --}}
<template id="module-editor-four-image-template">
  <div class="four-image-editor">
    <div class="top-spacing"></div>
    
    {{-- Module width settings --}}
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
            Full
          </div>
        </div>
      </div>
    </div>

    {{-- Module Title --}}
    <div class="editor-section">
      <div class="section-title">Module Title</div>
      <div class="section-content">
        <text-i18n v-model="form.title" @change="onChange" placeholder="Please enter the module title"></text-i18n>
      </div>
    </div>

    {{-- Subtitle --}}
    <div class="editor-section">
      <div class="section-title">Subtitle</div>
      <div class="section-content">
        <text-i18n v-model="form.subtitle" @change="onChange" placeholder="Please enter the subtitle"></text-i18n>
      </div>
    </div>

    {{-- Image Settings --}}
    <div class="editor-section">
      <div class="section-title">Image Settings</div>
      <div class="section-content">
        <div class="setting-tip">
          <i class="el-icon-info"></i>
          We recommend uploading images of the same size, ideally 400x400 pixels. Drag and drop sorting is supported.
        </div>

        <draggable ghost-class="dragabble-ghost" :list="form.images"
          :options="{ animation: 330, handle: '.icon-rank' }">
          <div class="image-item" v-for="(item, index) in form.images" :key="index">
            <div class="image-header" @click="itemShow(index)">
              <div class="image-info">
                <el-tooltip class="drag-handle" effect="dark" content="拖动排序" placement="left">
                  <i class="el-icon-rank"></i>
                </el-tooltip>
                <img :src="thumbnail(item.image[source.locale])" class="image-preview">
                <span class="image-label">picture @{{ index + 1 }}</span>
              </div>
              <div class="image-actions">
                <el-tooltip effect="dark" content="删除" placement="left">
                  <div class="remove-btn" @click.stop="removeImage(index)">
                    <i class="el-icon-delete"></i>
                  </div>
                </el-tooltip>
                <i :class="'el-icon-arrow-' + (item.show ? 'up' : 'down')"></i>
              </div>
            </div>
            <div :class="'image-content ' + (item.show ? 'active' : '')">
              <div class="image-upload-section">
                <single-image-selector v-model="item.image" :aspectRatio="1" :targetWidth="400"
                  :targetHeight="400"></single-image-selector>
                <div class="upload-tip">Recommended size: 400 x 400, image aspect ratio 1:1</div>
              </div>
              <div class="image-settings">
                <div class="setting-group">
                  <div class="setting-label">Image Description</div>
                  <text-i18n v-model="item.description" @change="onChange" placeholder="Please enter the image description"></text-i18n>
                </div>
                <div class="setting-group">
                  <div class="setting-label">Image Link</div>
                  <link-selector :hide-types="['catalog', 'static']" v-model="item.link" @change="onChange"></link-selector>
                </div>
              </div>
            </div>
          </div>
        </draggable>

        <div class="add-image-section" v-if="form.images.length < 4">
          <el-button type="primary" size="small" @click="addImage" icon="el-icon-circle-plus-outline">
            Add Image (@{{ form.images.length }}/4)
          </el-button>
        </div>
      </div>
    </div>
  </div>
</template>

{{-- Four Image Module Editor Script --}}
<script type="text/javascript">
  Vue.component('module-editor-four-image', {
    template: '#module-editor-four-image-template',
    props: ['module'],
    data: function() {
      return {
        debounceTimer: null,
        form: {
          title: {},
          subtitle: {},
          images: [],
          width: 'wide'
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
    created: function() {
      if (this.module) {
        this.form = JSON.parse(JSON.stringify(this.module));
      }

      if (!this.form.title) {
        this.$set(this.form, 'title', this.languagesFill(''));
      }

      if (!this.form.subtitle) {
        this.$set(this.form, 'subtitle', this.languagesFill(''));
      }

      if (!this.form.images) {
        this.$set(this.form, 'images', []);
      }

      if (!this.form.width) {
        this.$set(this.form, 'width', 'wide');
      }

      this.$emit('on-changed', this.form);
    },
    methods: {
      onChange() {
        // Clear the previous timer
        if (this.debounceTimer) {
          clearTimeout(this.debounceTimer);
        }
        
        // Set the new debounce timer
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
          const locale = this.source.locale;
          return image[locale] || (Object.values(image)[0] || PLACEHOLDER_IMAGE_URL);
        }
        return PLACEHOLDER_IMAGE_URL;
      },
      addImage() {
        if (this.form.images.length >= 4) {
          this.$message.warning('最多只能添加4张图片');
          return;
        }
        this.form.images.push({
          image: this.languagesFill(''),
          description: this.languagesFill(''),
          link: {
            type: 'product',
            value: ''
          },
          show: true
        });
      },
      removeImage(index) {
        this.form.images.splice(index, 1);
      },
      itemShow(index) {
        this.form.images[index].show = !this.form.images[index].show;
      }
    }
  });
</script>
