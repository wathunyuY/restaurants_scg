<template>
  <div>
    <p class="mt-3">Found items : {{getCountOfRestaurant}}</p>
    <b-table
      id="res-tbl"
      :fields="fields"
      fixed
      hover
      :items="getTransformRestaurants"
      :per-page="perPage"
      :current-page="currentPage"
    >
      <template #cell(rating)="data">
        <b-form-rating
          readonly
          v-model="data.value"
          variant="danger"
          no-border
          size="sm"
          inline
        ></b-form-rating>
      </template>
    </b-table>
    <b-pagination
      v-model="currentPage"
      :total-rows="getCountOfRestaurant"
      :per-page="perPage"
      last-number
      aria-controls="res-tbl"
      @change="loadMore"
      align="center"
    ></b-pagination>
  </div>
</template>

<script>
import { mapState, mapActions, mapGetters } from "vuex";
export default {
  computed: {
    ...mapState("restaurant", ["keyword", "next"]),
    ...mapGetters("restaurant", [
      "getTransformRestaurants",
      "getCountOfRestaurant",
    ]),
  },
  data() {
    return {
      fields: ["name", "address", "rating"],
      perPage: 5,
      currentPage: 1,
    };
  },
  methods: {
    ...mapActions("restaurant", ["getRestaurants", "getRestaurantsNextpage"]),
    /**
     * Get next list of restaurants
     */
    loadMore(e) {
      if (e * this.perPage + e > this.getCountOfRestaurant && this.next) { //If click on the last page of the table && has next page token
        this.getRestaurantsNextpage();
      }
    },
  },
};
</script>