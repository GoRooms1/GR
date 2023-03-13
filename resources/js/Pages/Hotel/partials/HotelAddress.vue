<template>
    <div class="flex gap-[8px]">
        <div class="w-[20px] flex-shrink-0">
            <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M10.4372 14.3568C13.3835 12.8545 15.6829 10.3665 15.6829 7.34147C15.6829 4.11531 13.0676 1.5 9.84146 1.5C6.61531 1.5 4 4.11531 4 7.34147C4 10.3665 6.29941 12.8545 9.24571 14.3568C9.62007 14.5477 10.0629 14.5477 10.4372 14.3568Z" stroke="#6171FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="M12.032 7.34131C12.032 8.55115 11.0513 9.53186 9.84143 9.53186C8.63159 9.53186 7.65088 8.55115 7.65088 7.34131C7.65088 6.1315 8.63159 5.15076 9.84143 5.15076C11.0513 5.15076 12.032 6.1315 12.032 7.34131Z" stroke="#6171FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
        </div>        
        <p class="text-[14px] leading-[16px]">
            <Link v-if="address?.city" :href="getAddressHref(address.city)" class="underline text-[#6170FF]">{{ address.city + ', '}}</Link>
            <Link v-if="address?.city_area" :href="getAddressHref(address.city, address.city_area)" class="underline text-[#6170FF]">{{ address.city_area + ', '}}</Link>
            <Link v-if="address?.city_district" :href="getAddressHref(address.city, address.city_area, address.city_district)" class="underline text-[#6170FF]">{{ address.city_district + ' район,'}}</Link><br>                            
            <span v-if="address.street_with_type != null">
                {{ address.street_with_type + ',' }}
            </span>
            <span v-if="address.house != null">
                {{ ' д.' +  address.house }}
            </span>           
        </p>
    </div>
</template>

<script>
    import { Link } from '@inertiajs/inertia-vue3';
    import _ from 'lodash'
    export default {
        components: {
            Link,
        },
        props: {
            address: Object,
        },
        methods: {
            getAddressHref(city = null, area = null, district = null) {
                let url = route('address');
                if (city) {
                    url += '/' + this.getAddressSlug(city);

                    if (area) {
                        url += '/area-' + this.getAddressSlug(area);

                        if (district) 
                            url += '/district-' + this.getAddressSlug(district); 
                    }

                    if (!area && district) {                        
                        url += '/district-' + this.getAddressSlug(district);
                    }
                }

                return url;
            },
            getAddressSlug(name) {
                let slugs = this.address?.slugs ?? [];
                return _.find(slugs, {address: name})?.slug;
            },
        },       
    }
</script>
