<template>
  <b-overlay :show="loading" rounded="sm">
    <b-form-row class="m-2">
      <b-col cols="10">
        <b-form-input
          @keyup.enter="getRestaurants(keyword)"
          id="search"
          placeholder="Search..."
          v-model="keyword"
        ></b-form-input>
      </b-col>
      <b-col cols="2">
        <b-button
          block
          variant="outline-danger"
          @click="getRestaurants(keyword)"
          ><b-icon-search></b-icon-search
        ></b-button>
      </b-col>
    </b-form-row>
  </b-overlay>
</template>
<script>
import { mapState, mapActions, mapGetters } from "vuex";
import { BIcon, BIconSearch } from "bootstrap-vue";
export default {
  components: {
    BIcon,
    BIconSearch,
  },
  data() {
    return {
      keyword: this.$store.state.restaurant.keyword,
    };
  },
  computed: {
    ...mapState("restaurant", ["loading"]),
  },
  methods: {
    ...mapActions("restaurant", ["getRestaurants"]),
  },
};
</script>