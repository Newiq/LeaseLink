@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- 图片展示区 -->
        <div class="relative h-96">
            <img src="{{ asset($rental->image_url) }}" alt="{{ $rental->title }}" 
                 class="w-full h-full object-cover">
        </div>

        <!-- 房产信息 -->
        <div class="p-6">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $rental->title }}</h1>
            
            <div class="grid grid-cols-2 gap-6 mb-6">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">房产详情</h2>
                    <div class="space-y-2">
                        <p class="text-gray-600"><span class="font-medium">价格:</span> ¥{{ number_format($rental->price, 2) }}/月</p>
                        <p class="text-gray-600"><span class="font-medium">面积:</span> {{ $rental->area }}平方米</p>
                        <p class="text-gray-600"><span class="font-medium">房型:</span> {{ $rental->layout }}</p>
                        <p class="text-gray-600"><span class="font-medium">地址:</span> {{ $rental->address }}</p>
                    </div>
                </div>

                <div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">房东信息</h2>
                    <div class="space-y-2">
                        <p class="text-gray-600"><span class="font-medium">姓名:</span> {{ $landlord->name }}</p>
                        <p class="text-gray-600"><span class="font-medium">联系方式:</span> {{ $landlord->phone ?? '暂无' }}</p>
                        <p class="text-gray-600"><span class="font-medium">邮箱:</span> {{ $landlord->email }}</p>
                    </div>
                </div>
            </div>

            <!-- 详细描述 -->
            <div class="mt-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-2">详细描述</h2>
                <p class="text-gray-600 whitespace-pre-line">{{ $rental->description }}</p>
            </div>
        </div>
    </div>
</div>
@endsection 