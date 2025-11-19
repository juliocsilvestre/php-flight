import { defineStore } from "pinia";
import { ref } from "vue";
import axios from "axios";

export const useAirportStore = defineStore("airport", () => {
  const airports = ref([]);
  const loading = ref(false);
  const error = ref(null);

  const fetchAirports = async () => {
    loading.value = true;
    error.value = null;

    try {
      const response = await axios.get("/airports");
      airports.value = response.data.data;
      return airports.value;
    } catch (err) {
      error.value =
        err.response?.data?.message || "Erro ao carregar aeroportos";
      throw err;
    } finally {
      loading.value = false;
    }
  };

  const getAirportById = (id) => {
    return airports.value.find((airport) => airport.id === id);
  };

  const getAirportByIataCode = (code) => {
    return airports.value.find((airport) => airport.iata_code === code);
  };

  return {
    airports,
    loading,
    error,
    fetchAirports,
    getAirportById,
    getAirportByIataCode,
  };
});
