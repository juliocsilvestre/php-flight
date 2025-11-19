<template>
  <form @submit.prevent="handleSubmit" class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <AirportSelect
        id="departure_airport"
        v-model="formData.departure_airport_id"
        :airports="airports"
        :loading="loadingAirports"
        label="Aeroporto de Partida"
        placeholder="Selecione o aeroporto de partida"
        required
        @change="handleDepartureChange"
      />

      <AirportSelect
        id="arrival_airport"
        v-model="formData.arrival_airport_id"
        :airports="airports"
        :loading="loadingAirports"
        label="Aeroporto de Chegada"
        placeholder="Selecione o aeroporto de chegada"
        required
        @change="handleArrivalChange"
      />
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div>
        <label
          for="departure_time"
          class="block text-sm font-medium text-gray-200 mb-2"
        >
          Horário de Partida <span class="text-red-400">*</span>
        </label>
        <input
          id="departure_time"
          v-model="formData.departure_time"
          type="datetime-local"
          required
          :min="minDateTime"
          class="block w-full px-4 py-3 bg-blue-900/30 border border-blue-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
        />
      </div>

      <div>
        <label
          for="arrival_time"
          class="block text-sm font-medium text-gray-200 mb-2"
        >
          Horário de Chegada <span class="text-red-400">*</span>
        </label>
        <input
          id="arrival_time"
          v-model="formData.arrival_time"
          type="datetime-local"
          required
          :min="formData.departure_time || minDateTime"
          class="block w-full px-4 py-3 bg-blue-900/30 border border-blue-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
        />
      </div>
    </div>

    <div
      v-if="error"
      class="bg-red-500/10 border border-red-500 text-red-400 px-4 py-3 rounded-lg"
    >
      <p class="font-medium">Erro:</p>
      <p class="text-sm">{{ error }}</p>
    </div>

    <div class="flex justify-end">
      <button
        type="submit"
        :disabled="loading || !isFormValid"
        class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-lg disabled:opacity-50 disabled:cursor-not-allowed transition transform hover:scale-105 active:scale-95"
      >
        <span v-if="loading" class="flex items-center">
          <svg
            class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
          >
            <circle
              class="opacity-25"
              cx="12"
              cy="12"
              r="10"
              stroke="currentColor"
              stroke-width="4"
            ></circle>
            <path
              class="opacity-75"
              fill="currentColor"
              d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
            ></path>
          </svg>
          Gerando Análise...
        </span>
        <span v-else class="flex items-center">
          <svg
            class="w-5 h-5 mr-2"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M13 10V3L4 14h7v7l9-11h-7z"
            ></path>
          </svg>
          Gerar Análise do Voo
        </span>
      </button>
    </div>
  </form>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import AirportSelect from "./AirportSelect.vue";

const props = defineProps({
  airports: {
    type: Array,
    required: true,
  },
  loadingAirports: {
    type: Boolean,
    default: false,
  },
  loading: {
    type: Boolean,
    default: false,
  },
  error: {
    type: String,
    default: "",
  },
});

const emit = defineEmits(["submit"]);

const formData = ref({
  departure_airport_id: "",
  arrival_airport_id: "",
  departure_time: "",
  arrival_time: "",
});

const minDateTime = computed(() => {
  const now = new Date();
  now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
  return now.toISOString().slice(0, 16);
});

const isFormValid = computed(() => {
  return (
    formData.value.departure_airport_id &&
    formData.value.arrival_airport_id &&
    formData.value.departure_time &&
    formData.value.arrival_time &&
    formData.value.departure_airport_id !== formData.value.arrival_airport_id
  );
});

const handleDepartureChange = (airport) => {
  // Optional: handle departure airport selection
};

const handleArrivalChange = (airport) => {
  // Optional: handle arrival airport selection
};

const handleSubmit = () => {
  if (!isFormValid.value) return;
  emit("submit", formData.value);
};

onMounted(() => {
  // Set default times (1 hour from now for departure, 3 hours from now for arrival)
  const now = new Date();
  const departureTime = new Date(now.getTime() + 60 * 60 * 1000);
  const arrivalTime = new Date(now.getTime() + 3 * 60 * 60 * 1000);

  departureTime.setMinutes(
    departureTime.getMinutes() - departureTime.getTimezoneOffset()
  );
  arrivalTime.setMinutes(
    arrivalTime.getMinutes() - arrivalTime.getTimezoneOffset()
  );

  formData.value.departure_time = departureTime.toISOString().slice(0, 16);
  formData.value.arrival_time = arrivalTime.toISOString().slice(0, 16);
});
</script>
