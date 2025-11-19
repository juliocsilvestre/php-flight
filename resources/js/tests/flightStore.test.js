import { describe, it, expect, beforeEach } from "vitest";
import { setActivePinia, createPinia } from "pinia";
import { useFlightStore } from "../stores/flightStore";

describe("Flight Store", () => {
  beforeEach(() => {
    setActivePinia(createPinia());
  });

  it("initializes with null flight", () => {
    const store = useFlightStore();
    expect(store.currentFlight).toBe(null);
    expect(store.loading).toBe(false);
    expect(store.error).toBe(null);
  });

  it("can clear error", () => {
    const store = useFlightStore();
    store.error = "Test error";

    store.clearError();

    expect(store.error).toBe(null);
  });

  it("maintains flight data after creation", () => {
    const store = useFlightStore();
    const mockFlight = {
      flight: { id: 1, departure_airport: {}, arrival_airport: {} },
      weather: {},
      season: {},
      traffic: {},
    };

    store.currentFlight = mockFlight;

    expect(store.currentFlight).toEqual(mockFlight);
    expect(store.currentFlight.flight.id).toBe(1);
  });
});
