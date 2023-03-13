<template>
    <div class="md:w-[70%] w-full overflow-hidden">
        <div class="max-w-[800px] mx-auto">
            <div class="overflow-hidden">
                <slot/>
            </div>
        </div>
        <div class="w-full flex justify-center">
            <div class="grid grid-cols-3 md:gap-[16px] gap-[4px]">
                <div v-for="(tab, index) in tabs" :key="index" @click="selectTab(index)" class="grow flex-shrink-0"
                  :class="tab.props.disabled == 'true' ? ' pointer-events-none' : ''"
                >
                    <div class="grow flex-shrink-0 flex items-center justify-between " :class="index == selectedIndex ? 'bg-[#6170FF]' : '' ">
                        <div class="w-[45%] bg-[#EAEFFD] rounded-tr-[8px] rounded-br-[8px] h-[16px]"></div>
                        <div class="w-[45%] bg-[#EAEFFD] rounded-tl-[8px] rounded-bl-[8px] h-[16px]"></div>
                    </div>
                    <button class="text-[16px] leading-[19px] w-full md:px-[17px] px-[3px] flex-shrink-0 h-[48px] rounded-[8px]" 
                      :class="(index == selectedIndex ? 'bg-[#6170FF] text-white' : 'bg-white') + ' ' + (tab.props.disabled == 'true' ? 'bg-slate-400 text-white pointer-events-none' : '') "
                    >
                        {{ tab.props.title }}
                    </button>
                </div>                
            </div>
        </div>
    </div>    
</template>

<script lang="ts">
import {defineComponent, reactive, provide, onMounted, onBeforeMount, toRefs, VNode} from "vue";
    
interface TabProps {
  title: string;
}
    
export default defineComponent({
  name: "Tabs",
  emits: ['changed'],
  setup(_, {slots, emit}) {
    const state = reactive({
      selectedIndex: 0,
      tabs: [] as VNode<TabProps>[],
      count: 0
    });
    
    provide("TabsProvider", state);
    
    const selectTab = (i: number) => {      
      state.selectedIndex = i;
      emit('changed', i);     
    };
    
    onBeforeMount(() => {
      if (slots.default) {
        state.tabs = slots.default().filter((child) => child.type.name === "Tab");
      }
    });

    onMounted(() => {
      selectTab(0);
    });

    return {...toRefs(state), selectTab};
  }
});
</script>
