<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mijn Bestellingen - MijnShop</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-slate-50 min-h-screen">

    @include('components.site-navbar')

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-900">Mijn Bestellingen</h1>
            <p class="text-slate-500 mt-1">Een overzicht van al je eerdere aankopen.</p>
        </div>

        @if($orders->isEmpty())
            {{-- Empty state --}}
            <div class="text-center py-24 bg-white rounded-2xl border border-dashed border-slate-300">
                <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-slate-700 mb-2">Nog geen bestellingen</h3>
                <p class="text-slate-500 mb-6">Je hebt hier nog niets gekocht. Ga shoppen!</p>
                <a href="{{ route('home') }}"
                   class="inline-flex items-center gap-2 px-6 py-3 bg-slate-800 text-white font-semibold rounded-lg hover:bg-slate-700 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    Naar de shop
                </a>
            </div>
        @else
            <div class="space-y-6">
                @foreach($orders as $order)
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

                        {{-- Order header --}}
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 px-6 py-4 bg-slate-50 border-b border-slate-200">
                            <div class="flex items-center gap-4">
                                <div>
                                    <p class="text-xs text-slate-400 uppercase tracking-wide font-medium">Bestelling</p>
                                    <p class="font-semibold text-slate-800">#{{ $order->id }}</p>
                                </div>
                                <div class="hidden sm:block w-px h-8 bg-slate-200"></div>
                                <div>
                                    <p class="text-xs text-slate-400 uppercase tracking-wide font-medium">Datum</p>
                                    <p class="font-medium text-slate-700">{{ $order->created_at->format('d M Y') }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                {{-- Status badge --}}
                                @php
                                    $statusColor = match($order->status) {
                                        'paid'      => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                        'pending'   => 'bg-amber-100 text-amber-700 border-amber-200',
                                        'cancelled' => 'bg-red-100 text-red-700 border-red-200',
                                        default     => 'bg-slate-100 text-slate-600 border-slate-200',
                                    };
                                    $statusLabel = match($order->status) {
                                        'paid'      => 'Betaald',
                                        'pending'   => 'In behandeling',
                                        'cancelled' => 'Geannuleerd',
                                        default     => ucfirst($order->status),
                                    };
                                @endphp
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold border {{ $statusColor }}">
                                    {{ $statusLabel }}
                                </span>
                                <div class="text-right">
                                    <p class="text-xs text-slate-400 uppercase tracking-wide font-medium">Totaal</p>
                                    <p class="font-bold text-slate-900 text-lg">€{{ number_format($order->total_price, 2, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>

                        {{-- Order items --}}
                        <div class="divide-y divide-slate-100">
                            @foreach($order->items as $item)
                                <div class="flex items-center justify-between px-6 py-4 gap-4">
                                    <div class="flex items-center gap-3 min-w-0">
                                        <div class="w-8 h-8 bg-slate-100 rounded-lg flex items-center justify-center flex-shrink-0 text-slate-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                            </svg>
                                        </div>
                                        <div class="min-w-0">
                                            <p class="text-sm font-medium text-slate-800 truncate">Product #{{ $item->product_id }}</p>
                                            <p class="text-xs text-slate-500">Aantal: {{ $item->quantity }}</p>
                                        </div>
                                    </div>
                                    <p class="text-sm font-semibold text-slate-700 flex-shrink-0">
                                        €{{ number_format($item->price * $item->quantity, 2, ',', '.') }}
                                    </p>
                                </div>
                            @endforeach
                        </div>

                    </div>
                @endforeach
            </div>
        @endif
    </div>

    @livewireScripts
</body>
</html>