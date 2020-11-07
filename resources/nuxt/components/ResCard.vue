<template>
  <div>
    <b-card
      :img-src="restaurant.photos"
      :img-alt="restaurant.name"
      :img-height="200"
      img-top
      tag="article"
      style="max-width: 20rem"
      class="mb-2 shadow-lg bg-white rounded"
    >
      <b-card-title style="font-size: 16px">
        {{ restaurant.name }}
      </b-card-title>
      <b-card-title style="font-size: 16px">
        <b-form-rating
          readonly
          v-model="restaurant.rating"
          variant="danger"
          no-border
          size="sm"
          inline
        ></b-form-rating>
      </b-card-title>
      <b-card-text>
        <small class="text-muted">
          <b-icon-geo-alt></b-icon-geo-alt>{{ restaurant.address }}
        </small>
      </b-card-text>
    </b-card>
  </div>
</template>
<script>
import { BIcon, BIconGeoAlt } from "bootstrap-vue";
export default {
  components: {
    BIcon,
    BIconGeoAlt,
  },
  props: ["restaurant"],
};
</script>