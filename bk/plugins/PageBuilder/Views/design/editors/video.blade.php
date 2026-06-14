{{-- Video Editor Module - Modern Style --}}
<template id="module-editor-video-template">
  <div class="video-editor">
    <div class="top-spacing"></div>
    
    {{-- module width settings --}}
    <div class="editor-section">
      <div class="section-title">
        <i class="el-icon-monitor"></i>
        module width
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

    {{-- Video Type Selection --}}
    <div class="editor-section">
      <div class="section-title">
        <i class="el-icon-video-camera"></i>
        Video Type
      </div>
      <div class="section-content">
        <div class="segmented-buttons">
          <div 
            :class="['segmented-btn', { active: module.videoType === 'local' }]" 
            @click="setVideoType('local')"
          >
            Local Video
          </div>
          <div 
            :class="['segmented-btn', { active: module.videoType === 'youtube' }]" 
            @click="setVideoType('youtube')"
          >
            YouTube
          </div>
          <div 
            :class="['segmented-btn', { active: module.videoType === 'vimeo' }]" 
            @click="setVideoType('vimeo')"
          >
            Vimeo
          </div>
        </div>
      </div>
    </div>

    {{-- Local Video Settings --}}
    <div class="editor-section" v-if="module.videoType === 'local'">
      <div class="section-title">
        <i class="el-icon-upload"></i>
        Video File
      </div>
      <div class="section-content">
        <div class="video-upload-wrapper">
          <div class="upload-area" @click="openVideoSelector">
            <div v-if="!module.videoUrl" class="upload-placeholder">
              <i class="el-icon-video-camera"></i>
              <p>Click to select video file</p>
              <span class="upload-tip">Supports MP4, WebM, OGV formats</span>
            </div>
            <div v-else class="video-preview">
              <video 
                :src="module.videoUrl" 
                controls 
                preload="metadata"
                class="preview-video"
              ></video>
              <div class="video-info">
                <span class="video-name">@{{ getVideoFileName(module.videoUrl) }}</span>
                <el-button 
                  type="danger" 
                  size="mini" 
                  icon="el-icon-delete" 
                  @click.stop="removeVideo"
                ></el-button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- Online Video Settings --}}
    <div class="editor-section" v-if="module.videoType === 'youtube' || module.videoType === 'vimeo'">
      <div class="section-title">
        <i class="el-icon-link"></i>
        Video Link
      </div>
      <div class="section-content">
        <div class="video-url-wrapper">
          <el-input 
            v-model="module.videoUrl" 
            :placeholder="getVideoUrlPlaceholder()"
            @change="onChange"
            size="small"
          >
            <template slot="prepend">
              <i :class="getVideoIcon()"></i>
            </template>
          </el-input>
          <div class="url-tips">
            @{{ getVideoUrlTips() }}
          </div>
        </div>
      </div>
    </div>

    {{-- Video Cover Settings --}}
    <div class="editor-section">
      <div class="section-title">
        <i class="el-icon-picture"></i>
        Video Cover
      </div>
      <div class="section-content">
        <div class="cover-image-wrapper">
          <single-image-selector 
            v-model="module.coverImage" 
            :aspectRatio="16/9" 
            :targetWidth="1280"
            :targetHeight="720"
            @change="onChange"
          ></single-image-selector>
          <div class="cover-tips">
            <i class="el-icon-info"></i>
            Recommended size: 1280 x 720 (16:9 aspect ratio)
          </div>
        </div>
      </div>
    </div>

    {{-- Video Control Settings --}}
    <div class="editor-section">
      <div class="section-title">
        <i class="el-icon-setting"></i>
        Play Control
      </div>
      <div class="section-content">
        <div class="control-settings">
          {{-- Auto Play --}}
          <div class="setting-item">
            <div class="setting-label">Auto Play</div>
            <div class="setting-control">
              <el-switch 
                v-model="module.autoplay" 
                @change="onChange"
                active-text="Enable" 
                inactive-text="Disable"
                size="small"
              ></el-switch>
            </div>
          </div>

          {{-- Loop play --}}
          <div class="setting-item">
            <div class="setting-label">Loop play</div>
            <div class="setting-control">
              <el-switch 
                v-model="module.loop" 
                @change="onChange"
                active-text="Enable" 
                inactive-text="Disable"
                size="small"
              ></el-switch>
            </div>
          </div>

          {{-- Mute Playback --}}
          <div class="setting-item">
            <div class="setting-label">Mute Playback</div>
            <div class="setting-control">
              <el-switch 
                v-model="module.muted" 
                @change="onChange"
                active-text="Enable" 
                inactive-text="Disable"
                size="small"
              ></el-switch>
            </div>
          </div>

          {{-- Show Control Bar --}}
          <div class="setting-item">
            <div class="setting-label">Show Control Bar</div>
            <div class="setting-control">
              <el-switch 
                v-model="module.controls" 
                @change="onChange"
                active-text="Show" 
                inactive-text="Hide"
                size="small"
              ></el-switch>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- Video Title --}}
    <div class="editor-section">
      <div class="section-title">
        <i class="el-icon-edit"></i>
        Video Title
      </div>
      <div class="section-content">
        <text-i18n 
          v-model="module.title" 
          @change="onChange" 
          placeholder="Please enter video title"
        ></text-i18n>
      </div>
    </div>

    {{-- Video Description --}}
    <div class="editor-section">
      <div class="section-title">
        <i class="el-icon-document"></i>
        Video Description
      </div>
      <div class="section-content">
        <text-i18n 
          v-model="module.description" 
          @change="onChange" 
          placeholder="Please enter video description"
          type="textarea"
          :rows="3"
        ></text-i18n>
      </div>
    </div>
  </div>
</template>

{{-- Video Edit Module Script --}}
<script type="text/javascript">
  Vue.component('module-editor-video', {
    template: '#module-editor-video-template',
    props: ['module'],
    
    data: function() {
      return {
        debounceTimer: null,
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
      // Initialize default values for module properties
      if (!this.module.videoType) {
        this.$set(this.module, 'videoType', 'local');
      }
      if (!this.module.videoUrl) {
        this.$set(this.module, 'videoUrl', '');
      }
      if (!this.module.coverImage) {
        this.$set(this.module, 'coverImage', this.languagesFill(''));
      }
      if (!this.module.title) {
        this.$set(this.module, 'title', this.languagesFill(''));
      }
      if (!this.module.description) {
        this.$set(this.module, 'description', this.languagesFill(''));
      }
      if (!this.module.autoplay) {
        this.$set(this.module, 'autoplay', false);
      }
      if (!this.module.loop) {
        this.$set(this.module, 'loop', false);
      }
      if (!this.module.muted) {
        this.$set(this.module, 'muted', false);
      }
      if (!this.module.controls) {
        this.$set(this.module, 'controls', true);
      }
      if (!this.module.width) {
        this.$set(this.module, 'width', 'wide');
      }
    },

    methods: {
      onChange() {
        // Initialize default values for module properties
        if (this.debounceTimer) {
          clearTimeout(this.debounceTimer);
        }

        // Set new debounce timer
        this.debounceTimer = setTimeout(() => {
          this.$emit('on-changed', this.module);
        }, 300);
      },

      setModuleWidth(width) {
        this.$set(this.module, 'width', width);
        this.onChange();
      },

      setVideoType(type) {
        this.$set(this.module, 'videoType', type);
        this.$set(this.module, 'videoUrl', '');
        this.onChange();
      },

      openVideoSelector() {
        // This requires integrating a file selector.
        // Use simple file input for now
        const input = document.createElement('input');
        input.type = 'file';
        input.accept = 'video/*';
        input.onchange = (e) => {
          const file = e.target.files[0];
          if (file) {
            // This should upload the file and retrieve the URL
            // For now, use the local URL
            this.$set(this.module, 'videoUrl', URL.createObjectURL(file));
            this.onChange();
          }
        };
        input.click();
      },

      removeVideo() {
        this.$set(this.module, 'videoUrl', '');
        this.onChange();
      },

      getVideoFileName(url) {
        if (!url) return '';
        const parts = url.split('/');
        return parts[parts.length - 1] || 'video.mp4';
      },

      getVideoUrlPlaceholder() {
        switch (this.module.videoType) {
          case 'youtube':
            return 'Please enter YouTube video link, e.g.: https://www.youtube.com/watch?v=VIDEO_ID';
          case 'vimeo':
            return 'Please enter Vimeo video link, e.g.: https://vimeo.com/VIDEO_ID';
          default:
            return 'Please enter video link';
        }
      },

      getVideoUrlTips() {
        switch (this.module.videoType) {
          case 'youtube':
            return 'Supports YouTube sharing links or embedded links';
          case 'vimeo':
            return 'Supports Vimeo sharing links or embedded links';
          default:
            return '';
        }
      },

      getVideoIcon() {
        switch (this.module.videoType) {
          case 'youtube':
            return 'el-icon-video-play';
          case 'vimeo':
            return 'el-icon-video-camera';
          default:
            return 'el-icon-video-camera';
        }
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