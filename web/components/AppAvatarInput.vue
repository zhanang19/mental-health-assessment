<template>
  <div>
    <v-hover>
      <template v-slot:default="{ hover }">
        <div>
          <v-avatar size="300" class="elevation-5">
            <v-img :src="!!src ? src : '/icon.png'"></v-img>
            <v-fade-transition>
              <v-overlay v-if="hover" absolute color="black">
                <v-tooltip bottom>
                  <template #activator="{ on, attrs }">
                    <v-btn v-on="on" v-bind="attrs" @click="$refs.avatar.click()" light fab>
                      <v-icon>mdi-cloud-upload-outline</v-icon>
                    </v-btn>
                  </template>
                  <span>Select an avatar</span>
                </v-tooltip>
              </v-overlay>
            </v-fade-transition>
          </v-avatar>
        </div>
      </template>
    </v-hover>

    <input @change="onChange($event)" type="file" accept="image/*" ref="avatar" hidden />
  </div>
</template>

<script>
export default {
  props: {
    src: {
      type: String,
    }
  },
  
  data: () => ({
    image: null,
  }),

  methods: {
    /**
     * @param { Event } event
     */
    async onChange(event) {
      const file = event.target.files[0];

      if (!file) {
        return;
      }

      const base64 = await this.base64Encode(file);

      await this.$emit("change", {
        event: event,
        previewUrl: URL.createObjectURL(file),
        base64,
        file,
      });

      this.image = base64;
    },
  },
};
</script>