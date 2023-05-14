<script setup>
import { useForm } from "@inertiajs/vue3";
import { usePage } from "@inertiajs/vue3";
import { vMaska } from "maska";
import Button from "@/components/ui/Button.vue";

const form = useForm({
  name: null,
  email: null,
  phone: null,
  message: null,
});

const submit = () => {
  form.post("/contacts");
};

const closeThanks = () => {
  delete usePage().props.flash.message;
  form.reset();
  form.clearErrors();
  form.name = null;
  form.phone = null;
  form.email = null;
  form.message = null;
};
</script>

<template>
  <form @submit.prevent="submit" class="w-full">
    <div
      v-if="$page.props.flash.message"
      class="w-full bg-white rounded-3xl p-4 flex flex-col items-center text-center"
    >
      <div class="w-full flex justify-end">
        <button @click="closeThanks">
          <svg
            width="24"
            height="24"
            viewBox="0 0 24 24"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <g clip-path="url(#clip0_228_7234)">
              <path
                d="M2 2L22 22"
                stroke="#6170FF"
                stroke-width="2"
                stroke-linecap="round"
              ></path>
              <path
                d="M2 22L22 2"
                stroke="#6170FF"
                stroke-width="2"
                stroke-linecap="round"
              ></path>
            </g>
            <defs>
              <clipPath id="clip0_228_7234">
                <rect width="24" height="24" fill="white"></rect>
              </clipPath>
            </defs>
          </svg>
        </button>
      </div>
      <div class="font-semibold mb-4 mt-20">Спасибо за обратную связь!</div>
      <div class="text-sm lg:px-24 mb-20">
        {{ $page.props.flash.message }}
      </div>
    </div>
    <div
      v-if="!$page.props.flash.message"
      class="w-full bg-white rounded-3xl p-4"
    >
      <h3 class="font-semibold text-base mb-4">Обратная связь</h3>
      <div class="flex-wrap lg:flex text-sm leading-4">
        <div class="lg:w-1/2 lg:pr-2">
          <label class="block w-full mb-2 xl:mb-2">
            <span class="flex">
              <span class="block mb-2">Имя</span>
              <span v-if="form.errors.name" class="pl-2">
                <img src="/img/attentionRed.svg"/>
              </span>
              <span v-if="form.errors.name" class="pl-2 text-red-500">
                Не заполнено
              </span>
            </span>
            <input
              v-model="form.name"
              name="name"
              class="w-full h-8 rounded-md py-2 px-2 placeholder-zinc-500"
              placeholder="Как к вам обращаться"
            />
          </label>
          <label class="block w-full mb-2 xl:mb-2">
            <span class="flex">
              <span class="block mb-2">Телефон</span>
              <span v-if="form.errors.phone" class="pl-2">
                <img src="/img/attentionRed.svg"/>
              </span>
              <span v-if="form.errors.phone" class="pl-2 text-red-500">
                Не заполнено
              </span>
            </span>
            <input
              v-model="form.phone"
              name="phone"
              v-maska
              :data-maska="'+7 (###) ### ## ##'"
              type="text"
              class="w-full h-8 rounded-md py-2 px-2 placeholder-zinc-500"
              placeholder="+7 (___) ___ __ __"
            />
          </label>
          <label class="block w-full mb-2 xl:mb-2">
            <span class="flex">
              <span class="block mb-2">Email</span>
              <span v-if="form.errors.email" class="pl-2">
                <img src="/img/attentionRed.svg"/>
              </span>
              <span v-if="form.errors.email" class="pl-2 text-red-500">
                Не заполнено
              </span>
            </span>
            <input
              v-model="form.email"
              name="email"
              type="text"
              class="w-full h-8 rounded-md py-2 px-2 placeholder-zinc-500"
              placeholder="Ваша@почта"
            />
          </label>
        </div>
        <div class="lg:w-1/2 lg:pl-2">
          <label class="block w-full">
            <span class="flex">
              <span class="block mb-2">Сообщение</span>
              <span v-if="form.errors.message" class="pl-2">
                <img src="/img/attentionRed.svg"/>
              </span>
              <span v-if="form.errors.message" class="pl-2 text-red-500">
                Не заполнено
              </span>
            </span>
            <textarea
              v-model="form.message"
              name="message"
              class="w-full h-44 rounded-md p-2 placeholder-zinc-500 h-[160px]"
              placeholder="Опишите вопрос или предложение"
            ></textarea>
          </label>
        </div>
      </div>
      <div class="flex-wrap lg:flex mt-4">
        <div class="lg:w-1/2 lg:pr-2 text-xs mb-4">
          Нажимая «Отправить» вы даёте согласие на обработку персональных данных
          и соглашаетесь c
          <a class="underline" href="#">пользовательским соглашением</a> и
          <a class="underline" href="#">политикой конфиденциальности</a>.
        </div>
        <div class="lg:w-1/2 lg:pl-2">
          <Button type="submit" classes="w-full"> Отправить </Button>
        </div>
      </div>
    </div>
  </form>
</template>
