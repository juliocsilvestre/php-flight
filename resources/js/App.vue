<template>
  <div
    id="app"
    class="min-h-screen bg-gradient-to-br from-blue-950 via-blue-900 to-blue-800"
  >
    <nav class="bg-blue-950/50 backdrop-blur-sm border-b border-blue-800">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
          <router-link to="/" class="flex items-center space-x-3">
            <svg
              class="w-8 h-8 text-blue-400"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"
              ></path>
            </svg>
            <span class="text-2xl font-bold text-white">Flight3D Vision</span>
          </router-link>
          <div class="flex items-center space-x-4">
            <router-link
              to="/"
              class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition"
            >
              Home
            </router-link>
          </div>
        </div>
      </div>
    </nav>

    <main>
      <router-view />
    </main>

    <footer
      class="bg-blue-950/30 backdrop-blur-sm border-t border-blue-800 mt-20"
    >
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="text-center text-gray-400">
          <p>&copy; 2025 Flight3D Vision. Todos os direitos reservados.</p>
          <p class="mt-2 text-sm">
            Sistema de análise e visualização 3D de voos
          </p>
        </div>
      </div>
    </footer>
  </div>
</template>

<script setup>
// App root component
</script>
