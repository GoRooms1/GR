<script setup>
import { useForm } from "@inertiajs/vue3";
import { usePage } from "@inertiajs/vue3";
// import { mask as vMask } from "vue-the-mask";
import _ from "lodash";
import Button from "@/components/ui/Button.vue";

const form = useForm({
  name: null,
  email: null,
  phone: null,
  message: null,
});

form.passedFields = {};

const valudationRules = {
  name: [],
  email: [],
  phone: [],
  message: [],
};

const validate = _.debounce((event) => {
  let field = {};
  field[event.target.name] = event.target.value;

  let fieldRules = {};
  fieldRules[event.target.name] = valudationRules[event.target.name];

  // let validation = intus.validate(field, fieldRules);
  if (true) {
    form.passedFields[event.target.name] = true;
    delete form.errors[event.target.name];
  } else {
    /*delete form.passedFields[event.target.name];
    form.setError(event.target.name, validation.errors());*/
  }
}, 500);

let isValidated = () => {
  return (
    Object.keys(form.passedFields).length == Object.keys(valudationRules).length
  );
};

const submit = () => {
  if (isValidated()) form.post(route("contact"));
};

const closeThanks = () => {
  delete usePage().props.flash.message;
  form.reset();
  form.clearErrors();
  form.passedFields = {};
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
              <span v-if="form.passedFields.name" class="pl-2">
                <svg
                  width="16"
                  height="16"
                  viewBox="0 0 16 16"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M10 6.5L7.20001 9.5L6 8.21429"
                    stroke="#6170FF"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  ></path>
                  <path
                    d="M8 14C11.3137 14 14 11.3137 14 8C14 4.68629 11.3137 2 8 2C4.68629 2 2 4.68629 2 8C2 11.3137 4.68629 14 8 14Z"
                    stroke="#6170FF"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  ></path>
                </svg>
              </span>
              <span v-if="form.errors.name" class="pl-2">
                <svg
                  width="16"
                  height="16"
                  viewBox="0 0 16 16"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M8 10.5002L8 10.5068"
                    stroke="#E1183D"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  ></path>
                  <path
                    d="M8 5.5L8 8"
                    stroke="#E1183D"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  ></path>
                  <path
                    d="M8 14C11.3137 14 14 11.3137 14 8C14 4.68629 11.3137 2 8 2C4.68629 2 2 4.68629 2 8C2 11.3137 4.68629 14 8 14Z"
                    stroke="#E1183D"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  ></path>
                </svg>
              </span>
              <span v-if="form.errors.name" class="pl-2 text-red-500">
                Не заполнено
              </span>
            </span>
            <input
              v-model="form.name"
              name="name"
              @input="validate"
              class="w-full h-8 rounded-md py-2 px-2 placeholder-zinc-500"
              placeholder="Как к вам обращаться"
              wfd-id="id6"
            />
          </label>
          <label class="block w-full mb-2 xl:mb-2">
            <span class="flex">
              <span class="block mb-2">Телефон</span>
              <span v-if="form.passedFields.phone" class="pl-2">
                <svg
                  width="16"
                  height="16"
                  viewBox="0 0 16 16"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M10 6.5L7.20001 9.5L6 8.21429"
                    stroke="#6170FF"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  ></path>
                  <path
                    d="M8 14C11.3137 14 14 11.3137 14 8C14 4.68629 11.3137 2 8 2C4.68629 2 2 4.68629 2 8C2 11.3137 4.68629 14 8 14Z"
                    stroke="#6170FF"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  ></path>
                </svg>
              </span>
              <span v-if="form.errors.phone" class="pl-2">
                <svg
                  width="16"
                  height="16"
                  viewBox="0 0 16 16"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M8 10.5002L8 10.5068"
                    stroke="#E1183D"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  ></path>
                  <path
                    d="M8 5.5L8 8"
                    stroke="#E1183D"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  ></path>
                  <path
                    d="M8 14C11.3137 14 14 11.3137 14 8C14 4.68629 11.3137 2 8 2C4.68629 2 2 4.68629 2 8C2 11.3137 4.68629 14 8 14Z"
                    stroke="#E1183D"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  ></path>
                </svg>
              </span>
              <span v-if="form.errors.phone" class="pl-2 text-red-500">
                Не заполнено
              </span>
            </span>
            <input
              v-model="form.phone"
              name="phone"
              @input="validate"
              v-mask="'+7 (###) ### ## ##'"
              type="text"
              class="w-full h-8 rounded-md py-2 px-2 placeholder-zinc-500"
              placeholder="+7 (___) ___ __ __"
              wfd-id="id7"
            />
          </label>
          <label class="block w-full mb-2 xl:mb-2">
            <span class="flex">
              <span class="block mb-2">Email</span>
              <span v-if="form.passedFields.email" class="pl-2">
                <svg
                  width="16"
                  height="16"
                  viewBox="0 0 16 16"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M10 6.5L7.20001 9.5L6 8.21429"
                    stroke="#6170FF"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  ></path>
                  <path
                    d="M8 14C11.3137 14 14 11.3137 14 8C14 4.68629 11.3137 2 8 2C4.68629 2 2 4.68629 2 8C2 11.3137 4.68629 14 8 14Z"
                    stroke="#6170FF"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  ></path>
                </svg>
              </span>
              <span v-if="form.errors.email" class="pl-2">
                <svg
                  width="16"
                  height="16"
                  viewBox="0 0 16 16"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M8 10.5002L8 10.5068"
                    stroke="#E1183D"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  ></path>
                  <path
                    d="M8 5.5L8 8"
                    stroke="#E1183D"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  ></path>
                  <path
                    d="M8 14C11.3137 14 14 11.3137 14 8C14 4.68629 11.3137 2 8 2C4.68629 2 2 4.68629 2 8C2 11.3137 4.68629 14 8 14Z"
                    stroke="#E1183D"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  ></path>
                </svg>
              </span>
              <span v-if="form.errors.email" class="pl-2 text-red-500">
                Не заполнено
              </span>
            </span>
            <input
              v-model="form.email"
              name="email"
              @input="validate"
              type="text"
              class="w-full h-8 rounded-md py-2 px-2 placeholder-zinc-500"
              placeholder="Ваша@почта"
              wfd-id="id8"
            />
          </label>
        </div>
        <div class="lg:w-1/2 lg:pl-2">
          <label class="block w-full">
            <span class="flex">
              <span class="block mb-2">Сообщение</span>
              <span v-if="form.passedFields.message" class="pl-2">
                <svg
                  width="16"
                  height="16"
                  viewBox="0 0 16 16"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M10 6.5L7.20001 9.5L6 8.21429"
                    stroke="#6170FF"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  ></path>
                  <path
                    d="M8 14C11.3137 14 14 11.3137 14 8C14 4.68629 11.3137 2 8 2C4.68629 2 2 4.68629 2 8C2 11.3137 4.68629 14 8 14Z"
                    stroke="#6170FF"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  ></path>
                </svg>
              </span>
              <span v-if="form.errors.message" class="pl-2">
                <svg
                  width="16"
                  height="16"
                  viewBox="0 0 16 16"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M8 10.5002L8 10.5068"
                    stroke="#E1183D"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  ></path>
                  <path
                    d="M8 5.5L8 8"
                    stroke="#E1183D"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  ></path>
                  <path
                    d="M8 14C11.3137 14 14 11.3137 14 8C14 4.68629 11.3137 2 8 2C4.68629 2 2 4.68629 2 8C2 11.3137 4.68629 14 8 14Z"
                    stroke="#E1183D"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  ></path>
                </svg>
              </span>
              <span v-if="form.errors.message" class="pl-2 text-red-500">
                Не заполнено
              </span>
            </span>
            <textarea
              v-model="form.message"
              name="message"
              @input="validate"
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
          <Button
            type="submit"
            v-bind:disabled="!isValidated()"
            classes="w-full"
          >
            Отправить
          </Button>
        </div>
      </div>
    </div>
  </form>
</template>
