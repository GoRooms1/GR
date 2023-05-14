<template>
  <div
    class="flex items-center gap-[8px] rounded-[10px] bg-[#3B24C6] h-[32px] px-[12px] w-[fit-content]"
  >
    <span class="text-white text-[12px] leading-[14px] whitespace-nowrap">{{
      title
    }}</span>
    <button type="button" @click="close()" v-if="removable == true">
      <img src="/img/close_tag.svg" alt="close"/>
    </button>
  </div>
</template>

<script>
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
        let attributes = this.$page.props.attributes ?? [];
        title =
          attributes.find(el => el.id == this.filterValue)?.name ?? title;
      } else if (this.filterKey == "is_hot") {
        title = "Горящие";
      } else if (this.filterKey == "cashback") {
        title = "Кэшбэк";
      } else if (this.filterKey == "low_cost") {
        title = "Low Cost";
      } else if (this.filterKey == "moderate") {
        title = "На модерации";
      } else if (this.filterKey == "period_cost") {
        let costTypes = this.$page.props.cost_types ?? [];
        let type = this.filterValue.split("_")?.[0] ?? 1;
        let costRange = this.filterValue.split("_")?.[1] ?? 0;

        let typeObj = costTypes.find(el => el.key == type);
        let costRanges = typeObj?.cost_ranges ?? [];
        let rangeObj = costRanges.find(el => el.key == costRange);

        title = typeObj?.name + ": " + rangeObj?.name;
      } else if (this.filterKey == "hotel_type") {
        let hotel_types = this.$page.props.hotel_types ?? [];
        title =
          hotel_types.find(el => el.key == this.filterValue)?.name ??
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
