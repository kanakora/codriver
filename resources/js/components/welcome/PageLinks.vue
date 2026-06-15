<script setup lang="ts">
import { Button } from '../ui/button';

import handIcon from '../../../img/hand-icon.png';
import carIcon from '../../../img/car-icon.png';
import carsIcon from '../../../img/cars-icon.png';
import trafficIcon from '../../../img/traffic-icon.png';
import signIcon from '../../../img/sign-icon.png';
import shipIcon from '../../../img/ship-icon.png';
import classRoomIcon from '../../../img/classroom-icon.png';
import steeringWheelIcon from '../../../img/steering-wheel-icon.png';

interface QuickLink {
  id: number;
  title: string;
  description: string;
  icon: string;
  iconAlt: string;
  link?: string;
}

const quickLinks: QuickLink[] = [
  {
    id: 1,
    title: 'Classes',
    description: 'Enroll in our driving classes and start your journey today',
    icon: classRoomIcon,
    iconAlt: 'classroom icon'
  },
  {
    id: 2,
    title: 'Duty Calculator',
    description: 'Calculate import duties and taxes for your vehicle',
    icon: shipIcon,
    iconAlt: 'ship icon'
  },
  {
    id: 3,
    title: 'Insurance',
    description: 'Compare and get the best insurance coverage for your vehicle',
    icon: handIcon,
    iconAlt: 'hand icon'
  },
  {
    id: 4,
    title: 'NTSA Services',
    description: 'Access NTSA services including license renewal and vehicle inspection',
    icon: carIcon,
    iconAlt: 'car icon'
  },
  {
    id: 5,
    title: 'Signs',
    description: 'Learn and understand all road signs for safe driving',
    icon: signIcon,
    iconAlt: 'road sign icon'
  },
  {
    id: 6,
    title: 'Traffic Rules',
    description: 'Stay updated with the latest traffic rules and regulations',
    icon: trafficIcon,
    iconAlt: 'traffic icon'
  },
  {
    id: 7,
    title: 'Vehicle Classes',
    description: 'Explore different vehicle categories and their requirements',
    icon: carsIcon,
    iconAlt: 'cars icon'
  },
  {
    id: 8,
    title: 'Driving Schools',
    description: 'Find accredited driving schools near your location',
    icon: steeringWheelIcon,
    iconAlt: 'steering wheel icon'
  },
];
</script>

<template>
  <section class="border-b border-gray-100 bg-white py-20 dark:border-gray-800 dark:bg-gray-950">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="mx-auto max-w-2xl text-center">
        <p class="text-sm font-semibold tracking-wide text-emerald-600 dark:text-emerald-400">PLATFORM</p>
        <h2 class="mt-3 text-4xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-5xl">
          Everything You Need
        </h2>
        <p class="mt-4 text-lg text-gray-500 dark:text-gray-400">
          Access all driving resources from one place
        </p>
      </div>

      <div class="mt-16 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div
          v-for="item in quickLinks"
          :key="item.id"
          class="group relative overflow-hidden rounded-2xl border border-gray-100 bg-white p-6 transition-all hover:border-gray-200 hover:shadow-lg hover:-translate-y-0.5 dark:border-gray-800 dark:bg-gray-900 dark:hover:border-gray-700"
        >
          <div class="mb-4 inline-flex size-12 items-center justify-center rounded-xl bg-emerald-50 dark:bg-emerald-900/20">
            <img :src="item.icon" :alt="item.iconAlt" class="size-7 object-contain dark:invert" />
          </div>

          <h5 class="text-lg font-semibold text-gray-900 dark:text-white">
            {{ item.title }}
          </h5>
          <p class="mt-1.5 text-sm leading-relaxed text-gray-500 dark:text-gray-400">
            {{ item.description }}
          </p>

          <div class="mt-4">
            <Button variant="ghost" size="sm" class="group/btn p-0 text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 dark:hover:text-emerald-300">
              Learn more
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="16"
                height="16"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
                class="ml-1.5 transition-transform group-hover/btn:translate-x-0.5"
              >
                <path d="M5 12h14" />
                <path d="m12 5 7 7-7 7" />
              </svg>
            </Button>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
