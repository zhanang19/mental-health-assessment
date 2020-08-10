<template>
  <nuxt-child></nuxt-child>
</template>

<script>
export default {
  head() {
    return {
      title: `${process.env.appName} | Survey Forms`,
    };
  },
};
</script>
