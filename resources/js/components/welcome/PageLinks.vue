<script setup lang="ts">
import handIcon from '../../../img/hand-icon.png';
import carIcon from '../../../img/car-icon.png';
import carsIcon from '../../../img/cars-icon.png';
import trafficIcon from '../../../img/traffic-icon.png';
import signIcon from '../../../img/sign-icon.png';
import shipIcon from '../../../img/ship-icon.png';
import classRoomIcon from '../../../img/classroom-icon.png';
import steeringWheelIcon from '../../../img/steering-wheel-icon.png';
import { Link } from '@inertiajs/vue3';

interface QuickLink {
  id: number;
  title: string;
  icon: string;
  iconAlt: string;
  link?: string;
}

const quickLinks: QuickLink[] = [
  { id: 1, title: 'Classes', icon: classRoomIcon, iconAlt: 'classroom icon', link: '/register' },
  { id: 2, title: 'Duty Calculator', icon: shipIcon, iconAlt: 'ship icon' },
  { id: 3, title: 'Insurance', icon: handIcon, iconAlt: 'hand icon' },
  { id: 4, title: 'NTSA Services', icon: carIcon, iconAlt: 'car icon' },
  { id: 5, title: 'Signs', icon: signIcon, iconAlt: 'road sign icon' },
  { id: 6, title: 'Traffic Rules', icon: trafficIcon, iconAlt: 'traffic icon' },
  { id: 7, title: 'Vehicle Classes', icon: carsIcon, iconAlt: 'cars icon' },
  { id: 8, title: 'Driving Schools', icon: steeringWheelIcon, iconAlt: 'steering wheel icon' },
];
</script>

<template>
  <section class="border-b border-gray-100 bg-white py-20 dark:border-gray-800 dark:bg-gray-950">
    <div class="mx-auto px-4 sm:px-6 lg:px-8">
      <div class="mx-auto max-w-2xl text-center">
        <p class="text-sm font-semibold tracking-wide text-emerald-600 dark:text-emerald-400">PLATFORM</p>
        <h2 class="mt-3 text-4xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-5xl">
          Everything You Need
        </h2>
        <p class="mt-4 text-lg text-gray-500 dark:text-gray-400">
          Access all driving resources from one place
        </p>
      </div>

      <div class="mt-12 flex justify-center flex-wrap gap-4 pb-2">
        <Link
          v-for="item in quickLinks"
          :key="item.id"
          :href="item.link ?? '/'"
          class="flex shrink-0 flex-col items-center gap-3 rounded-2xl bg-emerald-50/60 px-8 py-8 transition-colors hover:bg-emerald-100/80 dark:bg-emerald-950/20 dark:hover:bg-emerald-900/30"
        >
          <div class="flex size-20 items-center justify-center rounded-full bg-white shadow-sm dark:bg-gray-800">
            <img :src="item.icon" :alt="item.iconAlt" class="size-10 object-contain dark:invert" />
          </div>
          <span class="text-center text-sm font-semibold text-gray-800 dark:text-gray-200">
            {{ item.title }}
          </span>
        </Link>
      </div>
    </div>
  </section>
</template>
