<template>
  <div
    class="bg-blue-900/30 backdrop-blur-sm border border-blue-700 rounded-xl p-6 shadow-2xl"
  >
    <div class="flex items-center justify-between mb-6">
      <h2 class="text-2xl font-bold text-white">Detalhes do Voo</h2>
      <div class="flex items-center space-x-2">
        <span
          :class="seasonBadgeClass"
          class="px-3 py-1 rounded-full text-sm font-semibold"
        >
          {{ flight.season.label }}
        </span>
        <span
          :class="trafficBadgeClass"
          class="px-3 py-1 rounded-full text-sm font-semibold"
        >
          {{ flight.traffic.label }}
        </span>
      </div>
    </div>

    <div class="space-y-6">
      <!-- Route -->
      <div class="flex items-center justify-between">
        <div class="text-center flex-1">
          <div class="text-3xl font-bold text-blue-400">
            {{ flight.flight.departure_airport.iata_code }}
          </div>
          <div class="text-sm text-gray-400 mt-1">
            {{ flight.flight.departure_airport.city }}
          </div>
          <div class="text-xs text-gray-500">
            {{ flight.flight.departure_airport.country }}
          </div>
        </div>

        <div class="flex-1 flex flex-col items-center">
          <div class="text-gray-400 text-sm mb-2">
            {{ flight.flight.formatted_duration }}
          </div>
          <div
            class="w-full h-0.5 bg-gradient-to-r from-blue-400 via-blue-300 to-green-400 relative"
          >
            <div
              class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"
            >
              <svg
                class="w-6 h-6 text-white"
                fill="currentColor"
                viewBox="0 0 20 20"
              >
                <path
                  d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"
                />
              </svg>
            </div>
          </div>
          <div class="text-gray-400 text-xs mt-2">
            {{ flight.flight.distance_km }} km
          </div>
        </div>

        <div class="text-center flex-1">
          <div class="text-3xl font-bold text-green-400">
            {{ flight.flight.arrival_airport.iata_code }}
          </div>
          <div class="text-sm text-gray-400 mt-1">
            {{ flight.flight.arrival_airport.city }}
          </div>
          <div class="text-xs text-gray-500">
            {{ flight.flight.arrival_airport.country }}
          </div>
        </div>
      </div>

      <!-- Times -->
      <div class="grid grid-cols-2 gap-4">
        <div class="bg-blue-800/30 rounded-lg p-4">
          <div class="text-sm text-gray-400 mb-1">Partida</div>
          <div class="text-lg font-semibold text-white">
            {{ formatDateTime(flight.flight.departure_time) }}
          </div>
        </div>
        <div class="bg-blue-800/30 rounded-lg p-4">
          <div class="text-sm text-gray-400 mb-1">Chegada</div>
          <div class="text-lg font-semibold text-white">
            {{ formatDateTime(flight.flight.arrival_time) }}
          </div>
        </div>
      </div>

      <!-- Additional Info -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
        <div class="bg-blue-800/20 rounded-lg p-4">
          <div class="text-sm text-gray-400 mb-2">Informações da Temporada</div>
          <p class="text-white text-sm">{{ flight.season.description }}</p>
        </div>
        <div class="bg-blue-800/20 rounded-lg p-4">
          <div class="text-sm text-gray-400 mb-2">Recomendação de Chegada</div>
          <p class="text-white text-sm">{{ flight.traffic.recommendation }}</p>
          <p class="text-gray-400 text-xs mt-1">
            Tempo estimado: {{ flight.traffic.wait_time_estimate }}
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from "vue";

const props = defineProps({
  flight: {
    type: Object,
    required: true,
  },
});

const seasonBadgeClass = computed(() => {
  return props.flight.season.type === "high"
    ? "bg-orange-500/20 text-orange-400 border border-orange-500"
    : "bg-green-500/20 text-green-400 border border-green-500";
});

const trafficBadgeClass = computed(() => {
  const level = props.flight.traffic.level;
  if (level === "high")
    return "bg-red-500/20 text-red-400 border border-red-500";
  if (level === "medium")
    return "bg-yellow-500/20 text-yellow-400 border border-yellow-500";
  return "bg-green-500/20 text-green-400 border border-green-500";
});

const formatDateTime = (dateString) => {
  const date = new Date(dateString);
  return date.toLocaleString("pt-BR", {
    day: "2-digit",
    month: "2-digit",
    year: "numeric",
    hour: "2-digit",
    minute: "2-digit",
  });
};
</script>
