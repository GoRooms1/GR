<template>
  <AppHead title="Gorooms.ru" />
  <Menu/>
  <div class="filter h-40 pt-4 -mb-20 xl:pt-8">
    <div class="container mx-auto px-4 min-[1920px]:px-[10vw]">
      <div class="flex justify-between items-center">
        <span class="ml-5 text-white font-semibold text-[22px] lg:text-[28px]">Список Ваших бронирований</span>
      </div>
    </div>
  </div>
  <div class="container mx-auto px-4 relative z-10 min-[1920px]:px-[10vw]">
					<div class="scrollbar relative overflow-x-auto shadow-md rounded-xl">
						<table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
							<thead class=" text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
								<tr>
									<th scope="col" class="px-6 py-3">
										Дата создания
									</th>
									<th scope="col" class="px-6 py-3">
										Номер бронирования
									</th>
									<th scope="col" class="px-6 py-3">
										Название отеля
									</th>
									<th scope="col" class="px-6 py-3">
										Номер
									</th>
									<th scope="col" class="px-6 py-3">
										Период
									</th>
									<th scope="col" class="px-6 py-3">
										Заезд
									</th>
									<th scope="col" class="px-6 py-3">
										Выезд
									</th>
									<th scope="col" class="px-6 py-3">
										ФИО
									</th>
									<th scope="col" class="px-6 py-3">
										Телефон
									</th>
									<th scope="col" class="px-6 py-3">
										Комментарий
									</th>
									<th scope="col" class="px-6 py-3 text-center">
										Статус
									</th>
									<th scope="col" class="px-6 py-3 text-center">
										Действия
									</th>
								</tr>
							</thead>
							<tbody>
								<tr v-for="booking in bookings" :key="booking.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
									<td scope="col" class="px-6 py-3">
										{{ booking.created_at }}
									</td>
									<td scope="col" class="px-6 py-3 text-center">
										<span>{{ booking.book_number }}</span>
										<br>
										<!-- <a href="#" class="font-medium text-orange-500 hover:underline">Оставить отзыв</a> -->
									</td>
									<td class="px-6 py-4 text-center">
										<a :href="booking?.room?.hotel?.link" target="_blank" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">{{ booking?.room?.hotel?.name }}</a>
									</td>
									<td scope="col" class="px-6 py-3">
										{{ booking?.room?.full_name }}
									</td>
									<td scope="col" class="px-6 py-3">
										{{ booking.book_type }}
									</td>
									<td scope="col" class="px-6 py-3">
										{{ booking.from_date }}
									</td>
									<td scope="col" class="px-6 py-3">
										{{ booking.to_date }}
									</td>
									<td scope="col" class="px-6 py-3">
										{{ booking.client_fio }}
									</td>
									<td scope="col" class="px-6 py-3">
										{{ booking.client_phone }}
									</td>
									<td scope="col" class="px-6 py-3 overflow-hidden">
										<span class="block overflow-hidden max-h-20">
											{{ booking.book_comment }}
										</span>
									</td>
									<td scope="col" class="px-6 py-3 text-center font-semibold" :class="getStatusClass(booking?.status?.key)">
										{{ booking?.status?.value }}
									</td>
									<td scope="col" class="px-6 py-3">
										<button v-if="booking?.status?.key != 'cc' && booking?.status?.key !='ch'" class="w-full py-2 px-2 ml-2 text-center flex items-center justify-center flex-grow gap-[8px] text-white rounded-md transition duration-150 undefined bg-red-500 hover:bg-red-800" type="button">
											Отменить
										</button>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>        
</template>

<script>
import AppHead from "@/components/ui/AppHead.vue";
import Layout from "@/Layouts/Layout.vue";
import Menu from "./partials/Menu.vue";

export default {
  components: {
    AppHead,
    Layout,
    Menu,   
  },
  props: {
    bookings: [Object],
  },
  methods: {
    getStatusClass(status) {
      if (!status) return '';

      let map = {
        'wait' : 'text-gray-500',
        'in' : 'text-blue-600',
        'out' : 'text-green-500',
        'cc' : 'text-orange-500',
        'ch' : 'text-red-500'
      };
      
      return map[status];
    },      
  }
};
</script>
