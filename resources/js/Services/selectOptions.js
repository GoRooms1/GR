import vClickOutside from "click-outside-vue3";
export default function selectOptions() {
  return {
    directives: {
      clickOutside: vClickOutside.directive,
    },
    props: {
      placeholder: String,
      searchable: Boolean,
      notNull: {
        type: Boolean,
        default: false,
      },
      optionsArray: Array,
      modelValue: {
        type: [String, Number, Boolean],
        default: null,
      },
      position: {
        type: String,
        default: "relative md:static",
      },
    },
    mounted() {
      if (this.notNull == true && !this.selectedOption?.key) {
        this.value = this.optionsArray[0];
        this.emmitUpdate(this.optionsArray[0]);
      }
    },
    data() {
      return {
        collapsed: true,
        searchValue: "",
        value: null,
      };
    },
    emits: ["update:modelValue"],
    computed: {
      options: function () {
        if (this.searchValue) {
          let searchValue = this.searchValue.toLowerCase().trim();
          return this.optionsArray.filter(function (el) {
            return el.name.toString().toLowerCase().startsWith(searchValue);
          }, searchValue);
        } else {
          return this.optionsArray ?? [];
        }
      },
      selectedOption() {
        return this.modelValue ?? this.value;
      },
    },
    methods: {
      toggle() {
        this.collapsed = !this.collapsed;
      },
      hide() {
        this.collapsed = true;
      },
      choose(event) {
        let value = event.currentTarget.dataset["key"];
        if (value != this.modelValue) {
          this.emmitUpdate(value);
          this.value = value;
        }
        this.hide();
      },
      clear() {
        this.searchValue = "";
        this.emmitUpdate(null);
        this.value = null;
        this.hide();
      },
      getOptionName(key) {
        return this.optionsArray.find((el) => el.key == key)?.name ?? key;
      },

      emmitUpdate(value) {
        this.$emit("update:modelValue", value);
      },
    },
    watch: {
      modelValue: function (newVal, oldVal) {
        if (!newVal && oldVal) this.value = newVal;
      },
    },
  };
}
