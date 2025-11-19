import { describe, it, expect, vi, beforeEach } from "vitest";
import { mount } from "@vue/test-utils";
import AirportSelect from "../components/AirportSelect.vue";

describe("AirportSelect", () => {
  const mockAirports = [
    {
      id: 1,
      name: "Test Airport 1",
      iata_code: "TST",
      city: "Test City",
      country: "Test Country",
    },
    {
      id: 2,
      name: "Test Airport 2",
      iata_code: "TS2",
      city: "Test City 2",
      country: "Test Country 2",
    },
  ];

  it("renders properly", () => {
    const wrapper = mount(AirportSelect, {
      props: {
        id: "test-select",
        modelValue: "",
        airports: mockAirports,
        label: "Test Label",
      },
    });

    expect(wrapper.find("label").text()).toContain("Test Label");
    expect(wrapper.find("select").exists()).toBe(true);
  });

  it("displays all airports in options", () => {
    const wrapper = mount(AirportSelect, {
      props: {
        id: "test-select",
        modelValue: "",
        airports: mockAirports,
      },
    });

    const options = wrapper.findAll("option");
    expect(options).toHaveLength(3); // placeholder + 2 airports
    expect(options[1].text()).toContain("TST");
    expect(options[2].text()).toContain("TS2");
  });

  it("emits update:modelValue when selection changes", async () => {
    const wrapper = mount(AirportSelect, {
      props: {
        id: "test-select",
        modelValue: "",
        airports: mockAirports,
      },
    });

    const select = wrapper.find("select");
    await select.setValue("1");

    expect(wrapper.emitted("update:modelValue")).toBeTruthy();
    expect(wrapper.emitted("update:modelValue")[0]).toEqual([1]);
  });

  it("shows required indicator when required prop is true", () => {
    const wrapper = mount(AirportSelect, {
      props: {
        id: "test-select",
        modelValue: "",
        airports: mockAirports,
        label: "Required Field",
        required: true,
      },
    });

    expect(wrapper.find("label").text()).toContain("*");
  });

  it("displays error message when provided", () => {
    const errorMessage = "This field is required";
    const wrapper = mount(AirportSelect, {
      props: {
        id: "test-select",
        modelValue: "",
        airports: mockAirports,
        error: errorMessage,
      },
    });

    expect(wrapper.text()).toContain(errorMessage);
  });
});
