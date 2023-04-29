<template>
  <div
    class="flex items-center gap-[8px] rounded-[10px] bg-[#3B24C6] h-[32px] px-[12px] w-[fit-content]"
  >
    <span class="text-white text-[12px] leading-[14px] whitespace-nowrap">{{
      title
    }}</span>
    <button type="button" @click="close()" v-if="removable == true">
      <svg
        width="12"
        height="12"
        viewBox="0 0 12 12"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
      >
        <g clip-path="url(#clip0_791_56790)">
          <path
            d="M0.999268 0.999207L11.0001 11"
            stroke="white"
            stroke-width="2"
            stroke-linecap="round"
          ></path>
          <path
            d="M0.999268 11L11.0001 0.999207"
            stroke="white"
            stroke-width="2"
            stroke-linecap="round"
          ></path>
        </g>
        <defs>
          <clipPath id="clip0_791_56790">
            <rect width="12" height="12" fill="white"></rect>
          </clipPath>
        </defs>
      </svg>
    </button>
  </div>
</template>

<script>
import { usePage } from "@inertiajs/vue3";
import _ from "lodash";
export default {
  props: {
    filterModel: String,
    filterKey: String,
    isAttribute: {
      type: Boolean,
      default: false,
    },
    filterValue: [String, Number, Boolean],
    removable: {
      type: Boolean,
      default: true,
    },
  },
  created() {},
  data() {
    return {};
  },
  emmits: ["tag-closed"],
  computed: {
    title() {
      let title = this.filterValue ?? this.filterKey;
      if (this.isAttribute == true) {
        let attributes = usePage().props.attributes ?? [];
        title =
          _.find(attributes, (el) => el.id == this.filterValue)?.name ?? title;
      } else if (this.filterKey == "is_hot") {
        title = "Горящие";
      } else if (this.filterKey == "cashback") {
        title = "Кэшбэк";
      } else if (this.filterKey == "low_cost") {
        title = "Low Cost";
      } else if (this.filterKey == "period_cost") {
        let costTypes = usePage().props.cost_types ?? [];
        let type = this.filterValue.split("_")?.[0] ?? 1;
        let costRange = this.filterValue.split("_")?.[1] ?? 0;

        let typeObj = _.find(costTypes, (el) => el.key == type);
        let costRanges = typeObj?.cost_ranges ?? [];
        let rangeObj = _.find(costRanges, (el) => el.key == costRange);

        title = typeObj?.name + ": " + rangeObj?.name;
      } else if (this.filterKey == "hotel_type") {
        let hotel_types = usePage().props.hotel_types ?? [];
        title =
          _.find(hotel_types, (el) => el.key == this.filterValue)?.name ??
          title;
      }

      return title;
    },
  },
  methods: {
    close() {
      if (this.removable == true) {
        this.$emit("tag-closed", {
          modelType: this.filterModel,
          key: this.filterKey,
        });
      }
    },
  },
};
</script>
