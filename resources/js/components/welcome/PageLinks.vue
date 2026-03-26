<script setup lang="ts">
import { Button } from '../ui/button';

// Import images
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
  <div class="container mx-auto px-4 py-16 lg:py-24">
    <!-- Header Section with consistent spacing -->
    <div class="mb-12 lg:mb-16">
      <h2 class="title-header text-4xl lg:text-5xl mb-3">
        Quick Links
      </h2>
      <p class="text-muted-foreground text-lg">
        Access quick links to our platform
      </p>
    </div>
    
    <!-- Grid with consistent gap based on breakpoints -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
      <div
        v-for="item in quickLinks"
        :key="item.id"
        class="group flex flex-col items-center rounded-2xl border border-border bg-white dark:bg-gray-800 p-6 transition-all duration-200 hover:shadow-lg hover:-translate-y-1"
      >
        <!-- Icon Container with consistent sizing -->
        <div class="mb-5 flex size-20 items-center justify-center rounded-full bg-primary/10 dark:bg-primary/20">
          <img :src="item.icon" :alt="item.iconAlt" class="size-14 object-contain dark:invert" />
        </div>
        
        <!-- Content with precise spacing -->
        <div class="flex flex-col items-center space-y-3 text-center">
          <div class="space-y-2">
            <h5 class="text-xl font-bold tracking-tight">
              {{ item.title }}
            </h5>
            <p class="text-sm text-muted-foreground leading-relaxed max-w-70">
              {{ item.description }}
            </p>
          </div>
          
          <Button 
            variant="outline" 
            class="mt-2 group/btn"
          >
            Visit Page
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
              class="ml-2 transition-transform group-hover/btn:translate-x-1"
            >
              <path d="M15 3h6v6" />
              <path d="M10 14 21 3" />
              <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6" />
            </svg>
          </Button>
        </div>
      </div>
    </div>
  </div>
</template>