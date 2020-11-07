<template>
  <div>
    <div v-if="typeCard">
      <b-row>
        <b-col
          md="6"
          sm="12"
          lg="3"
          v-for="i in getTransformRestaurants"
          :key="i.place_id"
        >
          <ResCard :restaurant="i" />
        </b-col>
      </b-row>
      <div class="text-center" v-if="next">
        <b-spinner v-for="i in 3" :key="i" small type="grow"></b-spinner>
      </div>
      <div class="text-center" v-else>
        <h5 class="text-muted" v-if="getCountOfRestaurant > 0">
          This is all of `{{ keyword }}`, {{ getCountOfRestaurant }} items
        </h5>
        <h5 class="text-muted" v-else>
          Couldn't find any restaurant related to `{{ keyword }}` <b-icon-emoji-dizzy variant="danger"></b-icon-emoji-dizzy>
        </h5>
      </div>
    </div>
    <div v-else>
      <ResTable />
    </div>
  </div>
</template>
<script>
import ResCard from "./ResCard";
import ResTable from "./ResTable";
import { mapState, mapActions, mapGetters } from "vuex";
import { BIcon, BIconEmojiDizzy } from "bootstrap-vue";
export default {
  components: {
    ResCard,
    ResTable,
    BIcon,
    BIconEmojiDizzy
  },
  data() {
    return {};
  },
  mounted() {
    this.scroll();
  },
  computed: {
    ...mapState("restaurant", ["keyword", "next","typeCard"]),
    ...mapGetters("restaurant", [
      "getTransformRestaurants",
      "getCountOfRestaurant",
    ]),
  },
  methods: {
    ...mapActions("restaurant", ["getRestaurants", "getRestaurantsNextpage"]),
    /**
     * Get next list of restaurants
     */
    scroll() {
      window.onscroll = () => {//Scrolling listenner
        let bottomOfWindow =
          Math.ceil(document.documentElement.scrollTop) + window.innerHeight >=
          document.documentElement.offsetHeight;
        if (bottomOfWindow && this.next && this.typeCard) {//Check scrolling to the bottom yet? && Showtype is card && has naxt page token
          this.getRestaurantsNextpage();
        }
      };
    },
  },
};
</script>