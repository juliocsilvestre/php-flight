<template>
  <div
    class="bg-blue-900/30 backdrop-blur-sm border border-blue-700 rounded-xl p-6 shadow-2xl"
  >
    <h2 class="text-2xl font-bold text-white mb-6 flex items-center">
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
          d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"
        ></path>
      </svg>
      Visualização 3D do Voo
    </h2>

    <div
      v-if="enabled"
      class="relative rounded-lg overflow-hidden bg-blue-950/50 border border-blue-800"
    >
      <img
        :src="imageUrl"
        :alt="altText"
        class="w-full h-auto"
        @error="handleImageError"
      />
      <div
        class="absolute bottom-4 left-4 right-4 bg-blue-950/80 backdrop-blur-sm rounded-lg p-3"
      >
        <p class="text-white text-sm">
          Visualização 3D gerada do percurso de voo
        </p>
      </div>
    </div>

    <div
      v-else
      class="flex items-center justify-center h-64 bg-blue-950/50 rounded-lg border border-blue-800"
    >
      <div class="text-center">
        <svg
          class="w-16 h-16 text-blue-400 mx-auto mb-4"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
          ></path>
        </svg>
        <p class="text-gray-400">Visualização 3D não disponível</p>
      </div>
    </div>

    <div
      v-if="error"
      class="mt-4 bg-red-500/10 border border-red-500 text-red-400 px-4 py-3 rounded-lg"
    >
      <p class="text-sm">Erro ao carregar visualização: {{ error }}</p>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from "vue";

const props = defineProps({
  imageUrl: {
    type: String,
    required: true,
  },
  enabled: {
    type: Boolean,
    default: true,
  },
  altText: {
    type: String,
    default: "Visualização 3D do voo",
  },
});

const error = ref(null);

const handleImageError = () => {
  error.value = "Não foi possível carregar a imagem";
};
</script>
