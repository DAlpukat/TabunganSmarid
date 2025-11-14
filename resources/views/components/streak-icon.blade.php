
<div class="streak-navbar flex items-center {{ $class }}">
    <div class="relative">
        <svg xmlns="http://www.w3.org/2000/svg" 
             class="h-{{ $size }} w-{{ $size }} transition-colors duration-500 {{ $hasIncomeToday ? 'text-orange-400 flame-active' : 'text-gray-500' }}" 
             fill="currentColor" 
             viewBox="0 0 24 24">
            <path d="M12 2C11.5 2 10 4 10 6C10 8 8.5 10 8.5 12C8.5 12.8 9 13.5 9.5 14C9 14.5 8.5 15 8.5 16C8.5 17.5 10 19 12 19C14 19 15.5 17.5 15.5 16C15.5 15 15 14.5 14.5 14C15 13.5 15.5 12.8 15.5 12C15.5 10 14 8 14 6C14 4 12.5 2 12 2Z"/>
        </svg>
    </div>
    <span class="text-green-300 font-bold ml-2 {{ $textClass }}">
        Streak: <span id="streakCount{{ $id }}">{{ $streakCount }}</span>
    </span>
</div>