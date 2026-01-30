<x-layout>
  <div id="globeViz"></div>

  <div id="planeData" class="fixed left-0 top-0 z-40 w-80 h-screen bg-white/95 backdrop-blur-sm border-r shadow-xl hidden p-6 space-y-6">
    <div class="flex items-center pb-4 border-b border-gray-200">
      <button onclick='{document.getElementById("planeData").classList.add("hidden");}' class="text-gray-500 hover:text-black">x</button>
    </div>
    <div class="space-y-1">
      <p id="callname" class="text-2xl font-bold text-gray-900"></p>
      <p id="planeid" class="text-lg text-gray-700 font-medium"></p>
      <p id="regcountry" class="text-sm text-gray-500"></p>
    </div>
    <div class="grid grid-cols-2 gap-4 pt-4 border-t border-gray-200">
      <div>
        <p class="text-xs text-gray-500">Lat:</p>
        <p id="lat"></p>
      </div>
      <div>
        <p class="text-xs text-gray-500">Lng:</p>
        <p id="lng"></p>
      </div>
    </div>
    <div class="space-y-2 pt-4 border-t border-gray-200">
      <div class="flex justify-between">
        <span>Speed:</span>
        <p id="vel"></p>
      </div>
      <div class="flex justify-between">
        <span>Heading:</span>
        <p id="heading"></p>
      </div>
      <div class="flex justify-between">
        <span>Altitude:</span>
        <p id="height"></p>
      </div>
      <div class="grid grid-cols-2 gap-4 pt-4 border-t border-gray-200">
        <div>
          <p class="text-xs text-gray-500">Level status:</p>
          <p id="levelstatus"></p>
        </div>
        <div>
          <p class="text-xs text-gray-500">Status:</p>
          <p id="status"></p>
        </div>
      </div>
    </div>
  </div>
</x-layout>
