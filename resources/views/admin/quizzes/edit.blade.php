<x-admin-layout>
    <section class="text-gray-600 body-font relative">
        <div class="container px-5 py-24 mx-auto">
            <div class="flex flex-col text-center w-full mb-12">
                <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">クイズ編集</h1>
                <p class="lg:w-2/3 mx-auto leading-relaxed text-base"></p>
            </div>
            <div class="lg:w-1/2 md:w-2/3 mx-auto">

                <form
                    action="{{ route('admin.categories.quizzes.update', [
                        'categoryId' => $categoryId,
                        'quizId' => $quiz->id,
                    ]) }}"
                    method="POST" class="flex flex-wrap -m-2">
                    @csrf
                    {{-- 問題文 --}}
                    <div class="p-2 w-full">
                        <div class="relative">
                            <label for="question" class="leading-7 text-sm text-gray-600">問題文</label>
                            <textarea id="question" name="question"
                                class="w-full bg-gray-50 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out">{{ old('question') ? old('question') : $quiz->question }}</textarea>
                        </div>
                        {{-- 問題文のバリデーションエラーメッセージ表示 --}}
                        @error('question')
                            <div class="text-red-300">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- 解説 --}}
                    <div class="p-2 w-full">
                        <div class="relative">
                            <label for="explanation" class="leading-7 text-sm text-gray-600">解説</label>
                            <textarea id="explanation" name="explanation"
                                class="w-full bg-gray-50 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out">{{ old('explanation') ? old('explanation') : $quiz->explanation }}</textarea>
                        </div>
                        {{-- 解説のバリデーションエラーメッセージ表示 --}}
                        @error('explanation')
                            <div class="text-red-300">{{ $message }}</div>
                        @enderror
                    </div>
                    @foreach ($options as $option)
                        {{-- オプションIdを送る --}}
                        <input type="hidden" name="optionId{{ $loop->iteration }}" value="{{ $option->id }}">

                        {{-- 選択肢 --}}
                        <div class="p-2 w-full">
                            <div class="relative">
                                <label for="content{{ $loop->iteration }}"
                                    class="leading-7 text-sm text-gray-600">選択肢{{ $option->content }}</label>
                                <input type="text" id="content{{ $loop->iteration }}"
                                    name="content{{ $loop->iteration }}"
                                    value="{{ old("content{$loop->iteration}", $option->content) }}"
                                    class="w-full bg-gray-50 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                            </div>
                            {{-- 選択肢のバリデーションエラーメッセージ表示 --}}
                            @error("content{$loop->iteration}")
                                <div class="text-red-300">{{ $message }}</div>
                            @enderror
                        </div>


                        {{-- 選択肢の正解・不正解 --}}
                        <div class="p-2 w-full">
                            <div class="relative">
                                <label for="is_correct{{ $loop->iteration }}"
                                    class="leading-7 text-sm text-gray-600">選択肢{{ $loop->iteration }}の正解・不正解</label>
                                <select id="is_correct{{ $loop->iteration }}" name="is_correct{{ $loop->iteration }}"
                                    class="w-full bg-gray-50 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    @foreach ([1 => '正解', 0 => '不正解'] as $value => $label)
                                    <option value="{{ $value }}"
                                    {{-- どちらかが選択される --}}
                                    @selected(old("is_correct{$loop->iteration}", $option->is_correct) == $value)>
                                    {{ $label }}
                                </option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- 選択肢の正解・不正解のバリデーションエラーメッセージ表示 --}}
                            @error("isCorrect{$loop->iteration}")
                                <div class="text-red-300">{{ $message }}</div>
                            @enderror
                        </div>
                    @endforeach

                    <div class="p-2 w-full">
                        <button type="submit"
                            class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">更新
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</x-admin-layout>



{{-- オプションIdを送る --}}
{{-- <input type="hidden" name="optionId{{ $loop->iteration }}" value="{{ $option->id }}"> --}}

{{-- <div class="p-2 w-full">
    <div class="relative">
        <label for="content{{ $loop->iteration }}"
            class="leading-7 text-sm text-gray-600">選択肢{{ $option->content }}</label>
        <input type="text" id="content{{ $loop->iteration }}" name="content{{ $loop->iteration }}"
            value="{{ old("content{$loop->iteration}", $option->content) }}"
            class="w-full bg-gray-50 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
    </div> --}}
{{-- 選択肢のバリデーションエラーメッセージ表示 --}}
{{-- @error("content{$loop->iteration}")
        <div class="text-red-300">{{ $message }}</div>
    @enderror
</div> --}}

{{-- <div class="p-2 w-full">
    <div class="relative">
        <label for="isCorrect{{ $loop->iteration }}"
            class="leading-7 text-sm text-gray-600">選択肢{{ $loop->iteration }}の正解・不正解</label>
        <select id="isCorrect{{ $loop->iteration }}" name="isCorrect{{ $loop->iteration }}"
            class="w-full bg-gray-50 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
            @foreach ([1 => '正解', 0 => '不正解'] as $value => $label)
                <option value="{{ $value }}"
                    @if (old("isCorrect{$loop->iteration}", $option->is_correct) == $value) selected @endif>
                    {{ $label }}
                </option>
            @endforeach
        </select>
    </div> --}}
{{-- 選択肢の正解・不正解のバリデーションエラーメッセージ表示 --}}
{{-- @error("isCorrect{$loop->iteration}")
        <div class="text-red-300">{{ $message }}</div>
    @enderror
</div> --}}
