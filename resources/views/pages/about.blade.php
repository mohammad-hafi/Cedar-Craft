<x-layout>

      <section class="bg-gradient-to-br from-emerald-900 to-emerald-700 px-4 py-20 text-center text-white">
    <div class="mx-auto max-w-4xl">
    </div>
  </section>

  <section class="bg-white px-4 py-16">
    <div class="mx-auto max-w-7xl">
      <div class="mb-16">
        <h2 class="mb-8 text-center text-3xl font-extrabold text-emerald-900 md:text-4xl">Our Story</h2>
        <div class="mx-auto max-w-3xl space-y-5 text-justify text-lg text-gray-600">
          <p>
            {{setting('story')}}
          </p>
          <p>
            {{setting('info')}}
          </p>
        </div>
      </div>

      <div class="mb-16 grid grid-cols-1 gap-6 md:grid-cols-3">
        <div class="rounded-xl bg-white p-8 text-center shadow">
          <div class="text-4xl">🎯</div>
          <h3 class="mt-4 text-xl font-bold text-emerald-900">Our Mission</h3>
          <p class="mt-3 text-gray-600">
            {{setting('mission')}}
          </p>
        </div>

        <div class="rounded-xl bg-white p-8 text-center shadow">
          <div class="text-4xl">👁️</div>
          <h3 class="mt-4 text-xl font-bold text-emerald-900">Our Vision</h3>
          <p class="mt-3 text-gray-600">
            {{setting('vision')}}
          </p>
        </div>

        <div class="rounded-xl bg-white p-8 text-center shadow">
          <div class="text-4xl">💎</div>
          <h3 class="mt-4 text-xl font-bold text-emerald-900">Our Values</h3>
          <p class="mt-3 text-gray-600">
            {{setting('values')}}
          </p>
        </div>
      </div>

      <div class="mb-16">
        <h2 class="mb-10 text-center text-3xl font-extrabold text-emerald-900 md:text-4xl">Why Choose Cedar Craft?</h2>
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
          <div class="rounded-xl bg-amber-50 p-6 text-center shadow-sm">
            <div class="text-3xl">✨</div>
            <h4 class="mt-3 text-lg font-bold text-emerald-900">Premium Quality</h4>
            <p class="mt-2 text-gray-600">Handcrafted with the finest materials and attention to detail</p>
          </div>
          <div class="rounded-xl bg-amber-50 p-6 text-center shadow-sm">
            <div class="text-3xl">🎨</div>
            <h4 class="mt-3 text-lg font-bold text-emerald-900">Unique Designs</h4>
            <p class="mt-2 text-gray-600">One-of-a-kind pieces that showcase artistic creativity</p>
          </div>
          <div class="rounded-xl bg-amber-50 p-6 text-center shadow-sm">
            <div class="text-3xl">🌍</div>
            <h4 class="mt-3 text-lg font-bold text-emerald-900">Sustainable</h4>
            <p class="mt-2 text-gray-600">Eco-friendly materials and sustainable production practices</p>
          </div>
        </div>
      </div>

      <div class="grid grid-cols-1 gap-6 rounded-2xl bg-gradient-to-br from-emerald-900 to-emerald-700 p-10 text-center text-white sm:grid-cols-2 lg:grid-cols-4">
        <div>
          <div class="text-3xl font-extrabold text-amber-300">500+</div>
          <div class="mt-1 text-white/90">Products Created</div>
        </div>
        <div>
          <div class="text-3xl font-extrabold text-amber-300">2000+</div>
          <div class="mt-1 text-white/90">Happy Customers</div>
        </div>
        <div>
          <div class="text-3xl font-extrabold text-amber-300">15</div>
          <div class="mt-1 text-white/90">Years of Excellence</div>
        </div>
        <div>
          <div class="text-3xl font-extrabold text-amber-300">100%</div>
          <div class="mt-1 text-white/90">Satisfaction Guarantee</div>
        </div>
      </div>
    </div>
  </section>
<x-form.footer/>
</x-layout>
