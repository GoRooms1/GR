import _ from "lodash";
import { filterStore } from "./filterStore.js";

export const tempFilterStore = _.cloneDeep(filterStore);
