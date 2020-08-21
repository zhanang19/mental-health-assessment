<template>
  <div>
    <v-hover>
      <template v-slot:default="{ hover }">
        <div>
          <v-img :height="height" :width="width" src="/icon.png">
            <v-fade-transition>
              <v-overlay v-if="hover" absolute color="black">
                <v-btn @click="$refs.photo.click()" light x-large>
                  <v-icon left>mdi-cloud-upload-outline</v-icon>
                  <span>Select Photo</span>
                </v-btn>
              </v-overlay>
            </v-fade-transition>
          </v-img>
        </div>
      </template>
    </v-hover>

    <input @change="onChange($event)" type="file" accept="image/*" ref="photo" hidden />
  </div>
</template>

<script>
export default {
  props: {
    height: {
      type: String,
      default: () => "325",
    },

    width: {
      type: String,
      default: () => "100%",
    },
  },

  methods: {
    /**
     * @param { Event } event
     */
    async onChange(event) {
      const file = event.target.files[0];

      if (!file) {
        return;
      }

      await this.$emit("change", {
        event: event,
        base64: await this.base64Encode(file),
        previewUrl: URL.createObjectURL(file),
        file,
      });
    },
  },
};
</script>