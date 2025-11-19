<template>
  <div
    class="bg-blue-900/30 backdrop-blur-sm border border-blue-700 rounded-xl p-6 shadow-2xl"
  >
    <div class="flex items-center justify-between mb-6">
      <h2 class="text-2xl font-bold text-white flex items-center">
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
            d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"
          ></path>
        </svg>
        Condições Climáticas
      </h2>
      <div class="text-5xl">
        {{ getWeatherEmoji(weather.condition) }}
      </div>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
      <div class="bg-blue-800/30 rounded-lg p-4 text-center">
        <div class="text-3xl font-bold text-white">
          {{ weather.temperature }}°C
        </div>
        <div class="text-sm text-gray-400 mt-1">Temperatura</div>
        <div class="text-xs text-gray-500 mt-1">
          Sensação: {{ weather.feels_like }}°C
        </div>
      </div>

      <div class="bg-blue-800/30 rounded-lg p-4 text-center">
        <div class="text-3xl font-bold text-blue-300">
          {{ weather.humidity }}%
        </div>
        <div class="text-sm text-gray-400 mt-1">Umidade</div>
        <div class="text-xs text-gray-500 mt-1">
          {{ getHumidityDescription(weather.humidity) }}
        </div>
      </div>

      <div class="bg-blue-800/30 rounded-lg p-4 text-center">
        <div class="text-3xl font-bold text-green-300">
          {{ weather.wind_speed }} km/h
        </div>
        <div class="text-sm text-gray-400 mt-1">Vento</div>
        <div class="text-xs text-gray-500 mt-1">
          {{ getWindDirection(weather.wind_direction) }}
        </div>
      </div>

      <div class="bg-blue-800/30 rounded-lg p-4 text-center">
        <div class="text-3xl font-bold text-purple-300">
          {{ weather.visibility }} km
        </div>
        <div class="text-sm text-gray-400 mt-1">Visibilidade</div>
        <div class="text-xs text-gray-500 mt-1">
          {{ getVisibilityDescription(weather.visibility) }}
        </div>
      </div>
    </div>

    <div class="mt-6 bg-blue-800/20 rounded-lg p-4">
      <div class="flex items-center justify-between">
        <div>
          <div class="text-sm text-gray-400">Condição</div>
          <div class="text-lg font-semibold text-white">
            {{ weather.description }}
          </div>
        </div>
        <div>
          <div class="text-sm text-gray-400">Pressão</div>
          <div class="text-lg font-semibold text-white">
            {{ weather.pressure }} hPa
          </div>
        </div>
        <div>
          <div class="text-sm text-gray-400">Nuvens</div>
          <div class="text-lg font-semibold text-white">
            {{ weather.clouds }}%
          </div>
        </div>
      </div>
    </div>

    <div
      v-if="showFlightImpact"
      class="mt-4 p-4 rounded-lg"
      :class="flightImpactClass"
    >
      <div class="flex items-start">
        <svg
          class="w-5 h-5 mr-2 mt-0.5"
          fill="currentColor"
          viewBox="0 0 20 20"
        >
          <path
            fill-rule="evenodd"
            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
            clip-rule="evenodd"
          ></path>
        </svg>
        <div>
          <p class="font-semibold">{{ flightImpactTitle }}</p>
          <p class="text-sm mt-1">{{ flightImpactMessage }}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from "vue";

const props = defineProps({
  weather: {
    type: Object,
    required: true,
  },
});

const getWeatherEmoji = (condition) => {
  const emojiMap = {
    Clear: "☀️",
    Clouds: "☁️",
    Rain: "🌧️",
    Drizzle: "🌦️",
    Thunderstorm: "⛈️",
    Snow: "❄️",
    Mist: "🌫️",
    Fog: "🌫️",
  };
  return emojiMap[condition] || "🌤️";
};

const getHumidityDescription = (humidity) => {
  if (humidity < 30) return "Muito seco";
  if (humidity < 60) return "Confortável";
  if (humidity < 80) return "Úmido";
  return "Muito úmido";
};

const getWindDirection = (degrees) => {
  const directions = ["N", "NE", "E", "SE", "S", "SW", "W", "NW"];
  const index = Math.round(degrees / 45) % 8;
  return directions[index];
};

const getVisibilityDescription = (km) => {
  if (km >= 10) return "Excelente";
  if (km >= 5) return "Boa";
  if (km >= 2) return "Moderada";
  return "Baixa";
};

const showFlightImpact = computed(() => {
  return (
    props.weather.wind_speed > 40 ||
    props.weather.visibility < 5 ||
    ["Rain", "Thunderstorm", "Snow"].includes(props.weather.condition)
  );
});

const flightImpactClass = computed(() => {
  if (
    props.weather.condition === "Thunderstorm" ||
    props.weather.wind_speed > 60
  ) {
    return "bg-red-500/20 border border-red-500 text-red-300";
  }
  return "bg-yellow-500/20 border border-yellow-500 text-yellow-300";
});

const flightImpactTitle = computed(() => {
  if (props.weather.condition === "Thunderstorm") return "Atenção: Tempestade";
  if (props.weather.wind_speed > 40) return "Atenção: Ventos Fortes";
  if (props.weather.visibility < 5) return "Atenção: Visibilidade Reduzida";
  return "Atenção: Condições Adversas";
});

const flightImpactMessage = computed(() => {
  if (props.weather.condition === "Thunderstorm") {
    return "Possíveis atrasos devido a condições climáticas severas. Verifique o status do voo.";
  }
  if (props.weather.wind_speed > 40) {
    return "Ventos fortes podem causar turbulência e possíveis atrasos.";
  }
  if (props.weather.visibility < 5) {
    return "Baixa visibilidade pode afetar operações de pouso e decolagem.";
  }
  return "Condições climáticas podem afetar o voo. Mantenha-se informado.";
});
</script>
