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
      />
      <input
        type="range"
        class="range-max"
        ref="rangeMax"
        min="0"
        :max="maximum"
        v-model="maxPrice"
        @input="handling"
      />
    </div>
  </div>
</template>

<script setup>
import { ref, watch, watchEffect } from "vue";

const props = defineProps(["maximum"]);
const emits = defineEmits(["updateRange"]);

const leftPosition = ref("0%");
const rightPosition = ref("0%");
const minPrice = ref(0);
const maxPrice = ref(100);
const priceGap = ref(20);

const rangeMax = ref(null);

watch(
  () => props.maximum,
  (newMax, oldMax) => {
    if (newMax > 0) {
      maxPrice.value = newMax;
    }
  }
);

function handling() {
  updateRange();
  updateInput();
}

function updateRange() {
  emits("updateRange", minPrice.value, maxPrice.value);
  if (maxPrice.value - minPrice.value < priceGap.value) {
    if (minPrice.value > 0) {
      minPrice.value = maxPrice.value - priceGap.value;
    } else if (minPrice.value < 0) {
      minPrice.value = 0;
    } else {
      maxPrice.value = minPrice.value + priceGap.value;
    }
  }
}

function updateInput() {
  if (
    maxPrice.value - minPrice.value >= priceGap.value &&
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
<style scoped src="@/assets/css/RangeSlider.css"></style>
