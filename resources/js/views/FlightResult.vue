<template>
  <div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
      <!-- Header -->
      <div class="flex items-center justify-between mb-8">
        <button
          @click="goBack"
          class="flex items-center text-gray-300 hover:text-white transition"
        >
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
              d="M10 19l-7-7m0 0l7-7m-7 7h18"
            ></path>
          </svg>
          Voltar
        </button>
        <h1 class="text-3xl font-bold text-white">Análise do Voo</h1>
        <div class="w-20"></div>
      </div>

      <!-- Loading State -->
      <div v-if="loading" class="text-center py-20">
        <div
          class="inline-block animate-spin rounded-full h-16 w-16 border-t-2 border-b-2 border-blue-400"
        ></div>
        <p class="text-gray-400 mt-4 text-lg">Carregando análise do voo...</p>
      </div>

      <!-- Error State -->
      <div v-else-if="error" class="max-w-2xl mx-auto">
        <div
          class="bg-red-500/10 border border-red-500 rounded-xl p-8 text-center"
        >
          <svg
            class="w-16 h-16 text-red-400 mx-auto mb-4"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
            ></path>
          </svg>
          <h2 class="text-2xl font-bold text-red-400 mb-2">
            Erro ao carregar voo
          </h2>
          <p class="text-red-300 mb-6">{{ error }}</p>
          <button
            @click="goBack"
            class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition"
          >
            Voltar para página inicial
          </button>
        </div>
      </div>

      <!-- Flight Data -->
      <div v-else-if="flightData" class="space-y-8">
        <!-- Flight Card -->
        <FlightCard :flight="flightData" />

        <!-- 3D Visualization -->
        <ThreeDImage
          :image-url="flightData.visualization.render_3d_url"
          :enabled="flightData.visualization.enabled"
          alt-text="Visualização 3D do percurso de voo"
        />

        <!-- Weather Card -->
        <WeatherCard :weather="flightData.weather" />

        <!-- Additional Insights -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <!-- Season Details -->
          <div
            class="bg-blue-900/30 backdrop-blur-sm border border-blue-700 rounded-xl p-6 shadow-2xl"
          >
            <h3 class="text-xl font-bold text-white mb-4 flex items-center">
              <svg
                class="w-6 h-6 mr-2"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                ></path>
              </svg>
              Informações da Temporada
            </h3>
            <div class="space-y-4">
              <div class="flex items-start">
                <div
                  class="flex-shrink-0 w-10 h-10 bg-blue-600/30 rounded-full flex items-center justify-center mr-3"
                >
                  <span class="text-xl">{{
                    flightData.season.type === "high" ? "🔥" : "✨"
                  }}</span>
                </div>
                <div>
                  <div class="text-white font-semibold">
                    {{ flightData.season.label }}
                  </div>
                  <div class="text-sm text-gray-400 mt-1">
                    {{ flightData.season.description }}
                  </div>
                </div>
              </div>
              <div class="bg-blue-800/20 rounded-lg p-4">
                <div class="grid grid-cols-2 gap-4 text-sm">
                  <div>
                    <span class="text-gray-400">Impacto no preço:</span>
                    <span class="ml-2 text-white font-semibold">
                      {{
                        flightData.season.price_impact === "high"
                          ? "Alto"
                          : "Baixo"
                      }}
                    </span>
                  </div>
                  <div>
                    <span class="text-gray-400">Movimento:</span>
                    <span class="ml-2 text-white font-semibold">
                      {{ getCrowdingLabel(flightData.season.crowding_level) }}
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Traffic Details -->
          <div
            class="bg-blue-900/30 backdrop-blur-sm border border-blue-700 rounded-xl p-6 shadow-2xl"
          >
            <h3 class="text-xl font-bold text-white mb-4 flex items-center">
              <svg
                class="w-6 h-6 mr-2"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
                ></path>
              </svg>
              Tráfego do Aeroporto
            </h3>
            <div class="space-y-4">
              <div class="flex items-start">
                <div
                  class="flex-shrink-0 w-10 h-10 bg-blue-600/30 rounded-full flex items-center justify-center mr-3"
                >
                  <span class="text-xl">{{
                    getTrafficEmoji(flightData.traffic.level)
                  }}</span>
                </div>
                <div>
                  <div class="text-white font-semibold">
                    {{ flightData.traffic.label }}
                  </div>
                  <div class="text-sm text-gray-400 mt-1">
                    {{ flightData.traffic.description }}
                  </div>
                </div>
              </div>
              <div class="bg-blue-800/20 rounded-lg p-4 space-y-2">
                <div class="flex justify-between text-sm">
                  <span class="text-gray-400">Tempo de espera estimado:</span>
                  <span class="text-white font-semibold">{{
                    flightData.traffic.wait_time_estimate
                  }}</span>
                </div>
                <div class="mt-3 pt-3 border-t border-blue-700">
                  <p class="text-sm text-blue-300">
                    💡 {{ flightData.traffic.recommendation }}
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-center space-x-4 pt-8">
          <button
            @click="goBack"
            class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-lg transition transform hover:scale-105"
          >
            Nova Busca
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useRouter, useRoute } from "vue-router";
import { useFlightStore } from "../stores/flightStore";
import FlightCard from "../components/FlightCard.vue";
import WeatherCard from "../components/WeatherCard.vue";
import ThreeDImage from "../components/ThreeDImage.vue";

const router = useRouter();
const route = useRoute();
const flightStore = useFlightStore();

const flightData = ref(null);
const loading = ref(true);
const error = ref("");

onMounted(async () => {
  const flightId = route.params.id;

  if (!flightId) {
    error.value = "ID do voo não fornecido";
    loading.value = false;
    return;
  }

  try {
    // Check if we already have the flight data from creation
    if (
      flightStore.currentFlight &&
      flightStore.currentFlight.flight.id == flightId
    ) {
      flightData.value = flightStore.currentFlight;
    } else {
      // Fetch flight data
      const data = await flightStore.fetchFlight(flightId);
      flightData.value = data;
    }
  } catch (err) {
    error.value = flightStore.error || "Erro ao carregar os dados do voo";
  } finally {
    loading.value = false;
  }
});

const goBack = () => {
  router.push({ name: "Home" });
};

const getCrowdingLabel = (level) => {
  const labels = {
    high: "Alto",
    medium: "Médio",
    low: "Baixo",
  };
  return labels[level] || level;
};

const getTrafficEmoji = (level) => {
  const emojis = {
    high: "🔴",
    medium: "🟡",
    low: "🟢",
  };
  return emojis[level] || "⚪";
};
</script>
