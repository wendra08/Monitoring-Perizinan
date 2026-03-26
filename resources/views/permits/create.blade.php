@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Add New Permit</h2>
        <p class="text-gray-600 mt-1">Fill in the details to create a new permit</p>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('permits.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Permit Name -->
                <div class="md:col-span-2">
                    <label for="permit_name" class="block text-sm font-medium text-gray-700">Permit Name *</label>
                    <input type="text" name="permit_name" id="permit_name" value="{{ old('permit_name') }}" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border">
                </div>

                <!-- Permit Number -->
                <div>
                    <label for="permit_number" class="block text-sm font-medium text-gray-700">Permit Number <span class="text-gray-400">(Optional)</span></label>
                    <input type="text" name="permit_number" id="permit_number" value="{{ old('permit_number') }}"
                        placeholder="Leave blank if not applicable"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border">
                    <p class="mt-1 text-xs text-gray-500">Enter the official permit number if available</p>
                </div>

                <!-- Division - ADD THIS NEW FIELD -->
                <div>
                    <label for="division" class="block text-sm font-medium text-gray-700">Division/Department *</label>
                    <select name="division" id="division" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border">
                        <option value="">-- Select Division --</option>
                        <option value="Perencanaan Hutan" {{ old('division') === 'Perencanaan Hutan' ? 'selected' : '' }}>Perencanaan Hutan</option>
                        <option value="Sertifikasi & Studi (Kajian)" {{ old('division') === 'Sertifikasi & Studi (Kajian)' ? 'selected' : '' }}>Sertifikasi & Studi (Kajian)</option>
                        <option value="SDM & Umum" {{ old('division') === 'SDM & Umum' ? 'selected' : '' }}>SDM & Umum</option>
                        <option value="Lingkungan" {{ old('division') === 'Lingkungan' ? 'selected' : '' }}>Lingkungan</option>
                        <option value="K3" {{ old('division') === 'K3' ? 'selected' : '' }}>K3</option>
                        <option value="Sosial" {{ old('division') === 'Sosial' ? 'selected' : '' }}>Sosial</option>
                        <option value="Pengolahan Hasil Hutan" {{ old('division') === 'Pengolahan Hasil Hutan' ? 'selected' : '' }}>Pengolahan Hasil Hutan</option>
                        <option value="Penelitian dan Pengembangan" {{ old('division') === 'Penelitian dan Pengembangan' ? 'selected' : '' }}>Penelitian dan Pengembangan</option>
                        <option value="Sistem Informasi (IT)" {{ old('division') === 'Sistem Informasi (IT)' ? 'selected' : '' }}>Sistem Informasi (IT)</option>
                    </select>
                </div>

                <!-- Division Email -->
                <div>
                    <label for="division_email" class="block text-sm font-medium text-gray-700">Division Email <span class="text-gray-400">(Optional)</span></label>
                    <input type="email" name="division_email" id="division_email" value="{{ old('division_email') }}"
                        placeholder="division@company.com"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border">
                    <p class="mt-1 text-xs text-gray-500">Division/department email for reminders</p>
                </div>

                <!-- Issue Date -->
                <div>
                    <label for="issue_date" class="block text-sm font-medium text-gray-700">Issue Date *</label>
                    <input type="date" name="issue_date" id="issue_date" value="{{ old('issue_date') }}" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border">
                </div>

                <!-- Expiry Date -->
                <div>
                    <label for="expiry_date" class="block text-sm font-medium text-gray-700">Expiry Date *</label>
                    <input type="date" name="expiry_date" id="expiry_date" value="{{ old('expiry_date') }}" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border">
                </div>

                <!-- Boss Name -->
                <div>
                    <label for="boss_name" class="block text-sm font-medium text-gray-700">Boss Name *</label>
                    <input type="text" name="boss_name" id="boss_name" value="{{ old('boss_name') }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border">
                    <p class="mt-1 text-xs text-gray-500">Enter the name of the person responsible</p>
                </div>

                <!-- Boss Email 1 -->
                <div>
                    <label for="boss_email" class="block text-sm font-medium text-gray-700">Boss Email 1 *</label>
                    <input type="email" name="boss_email" id="boss_email" value="{{ old('boss_email') }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border">
                    <p class="mt-1 text-xs text-gray-500">Primary boss email</p>
                </div>

                <!-- Boss Email 2 -->
                <div>
                    <label for="boss_email_2" class="block text-sm font-medium text-gray-700">Boss Email 2 <span class="text-gray-400">(Optional)</span></label>
                    <input type="email" name="boss_email_2" id="boss_email_2" value="{{ old('boss_email_2') }}"
                        placeholder="secondboss@company.com"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border">
                    <p class="mt-1 text-xs text-gray-500">Secondary boss email (if applicable)</p>
                </div>

                <!-- Reminder Categories -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-3">Reminder Categories *</label>
                    <p class="text-xs text-gray-500 mb-3">Select which reminder notifications you want to receive for this permit</p>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-500 hover:bg-blue-50 transition">
                            <input type="checkbox" name="reminder_categories[]" value="6_months"
                                {{ is_array(old('reminder_categories')) && in_array('6_months', old('reminder_categories')) ? 'checked' : '' }}
                                class="w-5 h-5 text-blue-600 rounded focus:ring-blue-500">
                            <div class="ml-3">
                                <span class="font-semibold text-gray-900 block">6 Months Notice</span>
                                <p class="text-xs text-gray-600">Early warning (180 days)</p>
                            </div>
                        </label>

                        <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-yellow-500 hover:bg-yellow-50 transition">
                            <input type="checkbox" name="reminder_categories[]" value="3_months"
                                {{ is_array(old('reminder_categories')) && in_array('3_months', old('reminder_categories')) ? 'checked' : '' }}
                                class="w-5 h-5 text-yellow-600 rounded focus:ring-yellow-500">
                            <div class="ml-3">
                                <span class="font-semibold text-gray-900 block">3 Months Notice</span>
                                <p class="text-xs text-gray-600">Standard reminder (90 days)</p>
                            </div>
                        </label>

                        <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-red-500 hover:bg-red-50 transition">
                            <input type="checkbox" name="reminder_categories[]" value="1_month"
                                {{ is_array(old('reminder_categories')) && in_array('1_month', old('reminder_categories')) ? 'checked' : '' }}
                                class="w-5 h-5 text-red-600 rounded focus:ring-red-500">
                            <div class="ml-3">
                                <span class="font-semibold text-gray-900 block">1 Month Notice</span>
                                <p class="text-xs text-gray-600">Urgent reminder (30 days)</p>
                            </div>
                        </label>
                    </div>

                    @error('reminder_categories')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" rows="3"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border">{{ old('description') }}</textarea>
                </div>

                <!-- Document Upload -->
                <div class="md:col-span-2">
                    <label for="document" class="block text-sm font-medium text-gray-700 mb-2">
                        Upload Permit Document <span class="text-gray-400">(Optional)</span>
                    </label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-blue-400 transition">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="document" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                    <span>Upload a file</span>
                                    <input id="document" name="document" type="file" class="sr-only" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" onchange="displayFileName(this)">
                                </label>
                                <p class="pl-1">or drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">PDF, DOC, DOCX, JPG, PNG up to 10MB</p>
                            <p id="file-name" class="text-sm text-gray-700 font-medium mt-2"></p>
                        </div>
                    </div>
                    @error('document')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Buttons -->
            <div class="mt-6 flex items-center justify-end space-x-3">
                <a href="{{ route('permits.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300">
                    Cancel
                </a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                    Create Permit
                </button>
            </div>
        </form>
    </div>
</div>
<script>
function displayFileName(input) {
    const fileName = input.files[0]?.name;
    const fileNameDisplay = document.getElementById('file-name');
    if (fileName) {
        fileNameDisplay.textContent = '📄 ' + fileName;
    } else {
        fileNameDisplay.textContent = '';
    }
}
</script>
@endsection
