<template>
  <div class="wrapper">
    <div class="price-input">
      <div class="field">
        <span>Min</span>
        <input
          type="number"
          class="input-min"
          v-model="minPrice"
          @input="updateRange"
        />
      </div>
      <div class="separator">-</div>
      <div class="field">
        <span>Max</span>
        <input
          type="number"
          class="input-max"
          v-model="maxPrice"
          @input="updateRange"
        />
      </div>
    </div>
    <div class="slider">
      <div
        class="progress"
        :style="{ left: leftPosition, right: rightPosition }"
      ></div>
    </div>
    <div class="range-input">
      <input
        type="range"
        class="range-min"
        min="0"
        :max="maximum"
        v-model="minPrice"
        @input="handling"
        step="100"
      />
      <input
        type="range"
        class="range-max"
        min="0"
        :max="maximum"
        v-model="maxPrice"
        @input="handling"
        step="100"
      />
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";

const props = defineProps(["maximum", "priceGap"]);

const leftPosition = ref("0%");
const rightPosition = ref("0%");
const minPrice = ref(0);
const maxPrice = ref(props.maximum);
const priceGap = props.priceGap ?? 2000;

function handling(e) {
  updateRange();
  updateInput();
}

function updateRange(e) {
  console.log("min", minPrice.value, "max", maxPrice.value);
  if (maxPrice.value - minPrice.value < priceGap) {
    if (minPrice.value > 0) {
      minPrice.value = maxPrice.value - priceGap;
    } else {
      maxPrice.value = minPrice.value + priceGap;
    }
  }
}

function updateInput() {
  if (
    maxPrice.value - minPrice.value >= priceGap &&
    maxPrice.value <= props.maximum
  ) {
    // Calculate the percentage for positioning the range slider
    const minPercentage = (minPrice.value / props.maximum) * 100;
    const maxPercentage = (maxPrice.value / props.maximum) * 100;

    // Set the left and right positions for the range slider
    leftPosition.value = `${minPercentage}%`;
    rightPosition.value = `${100 - maxPercentage}%`;
  }
}
</script>

<style scoped>
/* Your CSS styles here */
</style>

<style scoped src="@/assets/css/RangeSlider.css"></style>
