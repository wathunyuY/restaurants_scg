<template>
  <div class="text-center mb-3 mt-3">
    <b-form-radio-group
      v-model="selected"
      :options="options"
      buttons
      button-variant="outline-danger"
      size="lg"
      @change="setTypeCard"
    ></b-form-radio-group>
  </div>
</template>
<script>
import { mapMutations } from "vuex";
export default {
  name: "Showcase",
  data() {
    return {
      selected: true,
      options: [
        { text: "Card", value: true },
        { text: "List", value: false },
      ],
    };
  },
  methods: {
    ...mapMutations("restaurant", ["setTypeCard"]),
  },
};
</script>