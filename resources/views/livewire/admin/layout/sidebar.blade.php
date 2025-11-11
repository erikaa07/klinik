<div class="w-full bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 flex">
    <!-- Sidebar -->
    <aside class="w-64 bg-gray-900 text-gray-100 flex flex-col border-r border-gray-800">
        <div class="px-6 py-5 flex items-center gap-3 border-b border-gray-800">
            <svg class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            <span class="text-xl font-bold tracking-tight"><a href="{{ route('dashboard') }}">Admin Klinik</a></span>
        </div>
    <nav class="flex-1 px-6 py-4">
        <ul class="space-y-2">
            <li>
                <a href="{{ route('admin.obat-input') }}" class="flex items-center px-3 py-2 rounded hover:bg-gray-800 transition">
                    <span>Input Data Obat</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.barang-masuk') }}" class="flex items-center px-3 py-2 rounded hover:bg-gray-800 transition">
                    <span>Barang Masuk</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.barang-keluar') }}" class="flex items-center px-3 py-2 rounded hover:bg-gray-800 transition">
                    <span>Barang Keluar</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.rekap-obat') }}" class="flex items-center px-3 py-2 rounded hover:bg-gray-800 transition font-semibold text-red-400">
                    <span>Rekap Obat</span>
                </a>
            </li>
            {{-- Loop Obat jika tersedia --}}
            @isset($obats)
                @foreach($obats as $obat)
                    <li>
                        <a href="{{ route('admin.obat.edit-obat', $obat->id) }}" class="flex items-center px-3 py-2 rounded hover:bg-gray-800 transition">
                            <span>Edit Obat: {{ $obat->nama }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.obat.edit-tanggal-obat', $obat->id) }}" class="flex items-center px-3 py-2 rounded hover:bg-gray-800 transition">
                            <span>Edit Tanggal Obat: {{ $obat->nama }}</span>
                        </a>
                    </li>
                @endforeach
            @endisset
        </ul>
    </nav>
        <div class="px-6 py-4 border-t border-gray-800">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 rounded bg-red-600 text-white hover:bg-red-700 transition font-semibold">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7"/>
                    </svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>