<template>
    <div class="block-editor">
        <div class="block-editor__header d-flex justify-content-between align-items-start">
            <h4 class="flex-shrink-1 mb-0" v-if="title">{{ title }}</h4>

            <div class="lang-switcher btn-group ml-auto" v-if="multilang">
                <button type="button" class="btn btn-sm"
                        v-for="(lang, index) in locales" :key="index"
                        :class="current === lang ? 'btn-primary' : 'btn-dark'"
                        @click.prevent="current = lang">
                    {{ langs[index] }}
                </button>
            </div>
        </div>

        <div class="block-editor__body">
            <template v-if="multilang">
                <div v-for="locale in locales" v-show="locale === current" :key="locale">
                    <slot :name="locale"></slot>
                </div>
            </template>

            <slot></slot>
        </div>
    </div>
</template>

<script>
  export default {
    props: {
      title: String,
      multilang: {
        type: Boolean,
        default() {
          return true;
        }
      }
    },
    data() {
      return {
        current: 'ru',
        locales: JSON.parse(document.head.querySelector('[name="locales"]').content),
        langs: []
      }
    },
    mounted() {
      const langs = {
        ru: 'Русский',
        ua: 'Українська',
        en: 'English'
      };
      this.langs = this.locales.map(l => {
        return langs[l];
      });
    }
  }
</script>
