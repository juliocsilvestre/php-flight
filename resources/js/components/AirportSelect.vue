<template>
  <div class="relative">
    <label
      v-if="label"
      :for="id"
      class="block text-sm font-medium text-gray-200 mb-2"
    >
      {{ label }}
      <span v-if="required" class="text-red-400">*</span>
    </label>
    <select
      :id="id"
      v-model="selectedValue"
      :disabled="disabled || loading"
      :required="required"
      class="block w-full px-4 py-3 bg-blue-900/30 border border-blue-700 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition disabled:opacity-50 disabled:cursor-not-allowed"
      @change="handleChange"
    >
      <option value="" disabled>{{ placeholder }}</option>
      <option
        v-for="airport in airports"
        :key="airport.id"
        :value="airport.id"
        class="bg-blue-900 text-white"
      >
        {{ airport.iata_code }} - {{ airport.name }} ({{ airport.city }},
        {{ airport.country }})
      </option>
    </select>
    <div v-if="loading" class="absolute right-3 top-10 animate-spin">
      <svg
        class="w-5 h-5 text-blue-400"
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
    </div>
    <p v-if="error" class="mt-1 text-sm text-red-400">{{ error }}</p>
  </div>
</template>

<script setup>
import { computed } from "vue";

const props = defineProps({
  id: {
    type: String,
    required: true,
  },
  modelValue: {
    type: [Number, String],
    default: "",
  },
  airports: {
    type: Array,
    required: true,
  },
  label: {
    type: String,
    default: "",
  },
  placeholder: {
    type: String,
    default: "Selecione um aeroporto",
  },
  required: {
    type: Boolean,
    default: false,
  },
  disabled: {
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

const emit = defineEmits(["update:modelValue", "change"]);

const selectedValue = computed({
  get: () => props.modelValue,
  set: (value) => emit("update:modelValue", value),
});

const handleChange = (event) => {
  const airportId = parseInt(event.target.value);
  const airport = props.airports.find((a) => a.id === airportId);
  emit("change", airport);
};
</script>
