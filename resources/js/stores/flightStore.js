import { defineStore } from "pinia";
import { ref } from "vue";
import axios from "axios";

export const useFlightStore = defineStore("flight", () => {
  const currentFlight = ref(null);
  const loading = ref(false);
  const error = ref(null);

  const createFlight = async (flightData) => {
    loading.value = true;
    error.value = null;

    try {
      const response = await axios.post("/flights", flightData);
      currentFlight.value = response.data.data;
      return currentFlight.value;
    } catch (err) {
      error.value = err.response?.data?.message || "Erro ao criar voo";
      if (err.response?.data?.errors) {
        const errors = err.response.data.errors;
        error.value = Object.values(errors).flat().join(", ");
      }
      throw err;
    } finally {
      loading.value = false;
    }
  };

  const fetchFlight = async (id) => {
    loading.value = true;
    error.value = null;

    try {
      const response = await axios.get(`/flights/${id}`);
      currentFlight.value = response.data.data;
      return currentFlight.value;
    } catch (err) {
      error.value = err.response?.data?.message || "Erro ao carregar voo";
      throw err;
    } finally {
      loading.value = false;
    }
  };

  const clearError = () => {
    error.value = null;
  };

  return {
    currentFlight,
    loading,
    error,
    createFlight,
    fetchFlight,
    clearError,
  };
});
