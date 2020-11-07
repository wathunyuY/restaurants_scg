<template>
  <b-container fluid="md">
    <Showcase />
    <Search/>
    <Restaurants />
  </b-container>
</template>

<script>
import Search from "./../components/Search";
import Showcase from "./../components/Showcase";
import Restaurants from "./../components/Restaurants";
import { mapState, mapActions, mapGetters } from "vuex";
export default {
  async asyncData({ store }) {
    await store.dispatch(
      "restaurant/getRestaurants",
      store.state.restaurant.keyword
    );
    return {};
  },
  components: {
    Search,
    Showcase,
    Restaurants,
  },
};
</script>