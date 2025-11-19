import { describe, it, expect, beforeEach } from "vitest";
import { setActivePinia, createPinia } from "pinia";
import { useAirportStore } from "../stores/airportStore";

describe("Airport Store", () => {
  beforeEach(() => {
    setActivePinia(createPinia());
  });

  it("initializes with empty airports", () => {
    const store = useAirportStore();
    expect(store.airports).toEqual([]);
    expect(store.loading).toBe(false);
    expect(store.error).toBe(null);
  });

  it("can find airport by id", () => {
    const store = useAirportStore();
    store.airports = [
      { id: 1, name: "Airport 1", iata_code: "AP1" },
      { id: 2, name: "Airport 2", iata_code: "AP2" },
    ];

    const airport = store.getAirportById(1);
    expect(airport).toBeDefined();
    expect(airport.name).toBe("Airport 1");
  });

  it("can find airport by IATA code", () => {
    const store = useAirportStore();
    store.airports = [
      { id: 1, name: "Airport 1", iata_code: "AP1" },
      { id: 2, name: "Airport 2", iata_code: "AP2" },
    ];

    const airport = store.getAirportByIataCode("AP2");
    expect(airport).toBeDefined();
    expect(airport.id).toBe(2);
  });

  it("returns undefined for non-existent airport", () => {
    const store = useAirportStore();
    store.airports = [{ id: 1, name: "Airport 1", iata_code: "AP1" }];

    const airport = store.getAirportById(999);
    expect(airport).toBeUndefined();
  });
});
