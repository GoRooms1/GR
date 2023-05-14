import cloneDeep from "lodash/cloneDeep";
import { filterStore } from "./filterStore.js";

export const tempFilterStore = cloneDeep(filterStore);
