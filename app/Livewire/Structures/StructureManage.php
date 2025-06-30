<?php

namespace App\Livewire\Structures;

use App\Models\ResponsiblePerson;
use Livewire\Component;
use App\Models\Building;
use App\Models\Floor;
use App\Models\Room;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule; // Validatsiya qoidasi uchun Rule import qilish

class StructureManage extends Component
{
    public $buildings;
    public $responsiblePeople; // Bu endi faqat ro'yxatni ko'rsatish uchun ishlatiladi, assign qilish uchun emas
    public $expandedBuildingId = null;
    public $expandedFloorId = null;

    // Modal controls
    public $showModal = false;
    // Yangi modal turlari qo'shildi: 'responsible-person'
    public $modalType = 'building'; // building|floor|room|responsible-person|assign-person-to-room|unassign-person-from-room
    public $actionType = 'create'; // create|edit|delete

    // Selected IDs for context (e.g., parent IDs for creation)
    public $selectedBuildingId;
    public $selectedFloorId;

    // Form fields (also used for edit/delete identification)
    public $building_name, $building_address, $building_description, $building_is_active = true, $building_id;
    public $floor_number, $floor_description, $floor_level, $floor_is_active = true, $floor_id;
    public $number, $room_name, $room_description, $room_is_active = true, $room_id; // number o'zgaruvchisiga o'zgartirildi

    // Properties for ResponsiblePerson CRUD (yangi)
    public $responsible_person_id;
    public $responsible_person_full_name;
    public $responsible_person_phone;
    public $responsible_person_passport_pdf_path;
    public $responsible_person_is_active = true;

    // New properties for responsible person assignment to room (avvalgidek qoldi)
    public $assign_person_room_id; // Room ID for which we are assigning/unassigning a person
    public $assign_person_id; // Responsible Person ID to be assigned/unassigned

    protected $listeners = ['refreshStructures' => 'loadData'];

    /**
     * Component yuklanganda ma'lumotlarni yuklaydi.
     * Loads data when the component is mounted.
     */
    public function mount()
    {
        $this->loadData();
    }

    /**
     * Binolar, qavatlar, xonalar va mas'ul shaxslar ma'lumotlarini yuklaydi.
     * Loads buildings, floors, rooms, and responsible people data.
     */
    public function loadData()
    {
        // Xonalar bilan birga mas'ul shaxslarni ham eager-load qilamiz
        $this->buildings = Building::with(['floors.rooms.responsiblePeople'])->orderBy('name')->get();
        // Endi responsiblePeople ro'yxatini to'liq yuklaymiz, chunki ularni alohida boshqaramiz
        $this->responsiblePeople = ResponsiblePerson::orderBy('full_name')->get();
    }

    /**
     * Komponentning view'ini render qiladi.
     * Renders the component's view.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.structures.structure-manage');
    }

    // --- UI actions ---
    /**
     * Binoni kengaytirish/yopish.
     * Toggles the expansion of a building.
     *
     * @param int $id Building ID
     */
    public function expandBuilding($id)
    {
        $this->expandedBuildingId = $this->expandedBuildingId === $id ? null : $id;
        $this->expandedFloorId = null; // Bino yopilganda qavatni ham yopish
    }

    /**
     * Qavatni kengaytirish/yopish.
     * Toggles the expansion of a floor.
     *
     * @param int $id Floor ID
     */
    public function expandFloor($id)
    {
        $this->expandedFloorId = $this->expandedFloorId === $id ? null : $id;
    }

    // --- Modal handlers ---
    /**
     * Modalni ochish va ma'lumotlarni yuklash.
     * Opens the modal and loads data for editing or setting up creation.
     *
     * @param string $modalType 'building', 'floor', 'room', 'responsible-person', 'assign-person-to-room', 'unassign-person-from-room'
     * @param string $actionType 'create', 'edit', or 'delete'
     * @param int|null $id O'zgartirilayotgan/o'chirilayotgan ob'ekt IDsi
     * @param int|null $parentId Yangi ob'ekt yaratish uchun ota ob'ekt IDsi (masalan, bino IDsi qavat uchun, xona IDsi shaxs biriktirish uchun)
     * @param int|null $childId Ba'zi hollarda, masalan, shaxsni biriktirishda (parentID=room_id, childID=person_id)
     */
    public function openModal($modalType, $actionType = 'create', $id = null, $parentId = null, $childId = null)
    {
        $this->resetErrorBag(); // Oldingi xatolarni tozalash
        $this->resetAllFields(); // Barcha form maydonlarini tozalash
        $this->modalType = $modalType;
        $this->actionType = $actionType;

        if ($modalType === 'building') {
            $this->building_id = $id; // IDni saqlash (tahrirlash/o'chirish uchun)
            if ($actionType === 'edit' && $id) {
                $b = Building::findOrFail($id);
                $this->building_name = $b->name;
                $this->building_address = $b->address;
                $this->building_description = $b->description;
                $this->building_is_active = $b->is_active;
            }
        } elseif ($modalType === 'floor') {
            $this->floor_id = $id; // IDni saqlash (tahrirlash/o'chirish uchun)
            $this->selectedBuildingId = $parentId; // Binoning IDsi (yaratish konteksti uchun)
            if ($actionType === 'edit' && $id) {
                $f = Floor::findOrFail($id);
                $this->floor_number = $f->floor_number;
                $this->floor_level = $f->level;
                $this->floor_description = $f->description;
                $this->floor_is_active = $f->is_active;
            }
        } elseif ($modalType === 'room') {
            $this->room_id = $id; // IDni saqlash (tahrirlash/o'chirish uchun)
            $this->selectedFloorId = $parentId; // Qavatning IDsi (yaratish konteksti uchun)
            if ($actionType === 'edit' && $id) {
                $r = Room::findOrFail($id);
                $this->number = $r->number; // To'g'ri o'zgaruvchi nomi
                $this->room_name = $r->name;
                $this->room_description = $r->description;
                $this->room_is_active = $r->is_active;
            }
        } elseif ($modalType === 'responsible-person') { // Yangi mas'ul shaxs CRUD uchun modal
            $this->responsible_person_id = $id; // IDni saqlash
            if ($actionType === 'edit' && $id) {
                $rp = ResponsiblePerson::findOrFail($id);
                $this->responsible_person_full_name = $rp->full_name;
                $this->responsible_person_phone = $rp->phone;
                $this->responsible_person_passport_pdf_path = $rp->passport_pdf_path;
                $this->responsible_person_is_active = $rp->is_active;
            }
        } elseif ($modalType === 'assign-person-to-room') {
            $this->assign_person_room_id = $parentId; // Biriktirilayotgan xonaning IDsi
            // Bu modal faqat tayinlash uchun, shuning uchun 'edit' konteksti yo'q
        } elseif ($modalType === 'unassign-person-from-room') {
            $this->assign_person_room_id = $parentId; // Xona IDsi
            $this->assign_person_id = $childId; // O'chirilayotgan mas'ul shaxs IDsi
        }

        $this->showModal = true;
    }

    /**
     * Modalni yopish va barcha form maydonlarini tozalash.
     * Closes the modal and resets all form fields.
     */
    public function closeModal()
    {
        $this->showModal = false;
        $this->resetAllFields();
    }

    // --- CRUD actions ---
    /**
     * Ma'lumotlarni saqlash (yaratish yoki yangilash).
     * Saves data (create or update).
     */
    public function save()
    {
        $message = '';
        try {
            if ($this->modalType === 'building') {
                $this->validate([
                    'building_name' => 'required|string|max:255',
                    'building_address' => 'nullable|string|max:255',
                    'building_description' => 'nullable|string',
                    'building_is_active' => 'required|boolean',
                ]);
                Building::updateOrCreate(['id' => $this->building_id], [
                    'name' => $this->building_name,
                    'address' => $this->building_address,
                    'description' => $this->building_description,
                    'is_active' => $this->building_is_active,
                ]);
                $message = $this->actionType === 'create' ? 'Building created successfully!' : 'Building updated successfully!';
            } elseif ($this->modalType === 'floor') {
                $this->validate([
                    'selectedBuildingId' => 'required|exists:buildings,id',
                    'floor_number' => [
                        'required',
                        'integer',
                        Rule::unique('floors')->where(fn ($query) => $query->where('building_id', $this->selectedBuildingId))->ignore($this->floor_id)
                    ],
                    'floor_level' => 'required|integer',
                    'floor_description' => 'nullable|string',
                    'floor_is_active' => 'required|boolean',
                ]);
                Floor::updateOrCreate(['id' => $this->floor_id], [
                    'building_id' => $this->selectedBuildingId,
                    'floor_number' => $this->floor_number,
                    'level' => $this->floor_level,
                    'description' => $this->floor_description,
                    'is_active' => $this->floor_is_active,
                ]);
                $message = $this->actionType === 'create' ? 'Floor created successfully!' : 'Floor updated successfully!';
            } elseif ($this->modalType === 'room') {
                $this->validate([
                    'selectedFloorId' => 'required|exists:floors,id',
                    'number' => [
                        'nullable',
                        'string',
                        'max:255',
                        Rule::unique('rooms')->where(fn ($query) => $query->where('floor_id', $this->selectedFloorId))->ignore($this->room_id)
                    ],
                    'room_name' => 'required|string|max:255',
                    'room_description' => 'nullable|string',
                    'room_is_active' => 'required|boolean',
                ]);

                Room::updateOrCreate(['id' => $this->room_id], [
                    'floor_id' => $this->selectedFloorId,
                    'number' => $this->number, // Eski 'number' o'rniga 'number'
                    'name' => $this->room_name,
                    'description' => $this->room_description,
                    'is_active' => $this->room_is_active,
                ]);

                $message = $this->actionType === 'create' ? 'Room created successfully!' : 'Room updated successfully!';
            } elseif ($this->modalType === 'responsible-person') { // Mas'ul shaxsni yaratish/yangilash
                $this->validate([
                    'responsible_person_full_name' => 'required|string|max:255',
                    'responsible_person_phone' => 'nullable|string|max:255',
                    'responsible_person_passport_pdf_path' => 'nullable|string|max:255', // Fayl yuklash bo'lsa boshqacha bo'ladi
                    'responsible_person_is_active' => 'required|boolean',
                ]);
                ResponsiblePerson::updateOrCreate(['id' => $this->responsible_person_id], [
                    'full_name' => $this->responsible_person_full_name,
                    'phone' => $this->responsible_person_phone,
                    'passport_pdf_path' => $this->responsible_person_passport_pdf_path,
                    'is_active' => $this->responsible_person_is_active,
                ]);
                $message = $this->actionType === 'create' ? 'Responsible person created successfully!' : 'Responsible person updated successfully!';

            } elseif ($this->modalType === 'assign-person-to-room') {
                $this->validate([
                    'assign_person_room_id' => 'required|exists:rooms,id',
                    'assign_person_id' => [
                        'required',
                        'exists:responsible_people,id',
                        Rule::unique('room_responsible_person')->where(function ($query) {
                            return $query->where('room_id', $this->assign_person_room_id);
                        })
                    ],
                ]);

                $room = Room::findOrFail($this->assign_person_room_id);
                $room->responsiblePeople()->attach($this->assign_person_id);
                $message = 'Responsible person assigned to room successfully!';
            }
            Session::flash('message', $message);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Session::flash('error', 'Validation failed: Please check your input.');
            Log::error('Validation Error: ' . $e->getMessage(), $e->errors());
            throw $e;
        } catch (\Exception $e) {
            Session::flash('error', 'An error occurred: ' . $e->getMessage());
            Log::error('CRUD Error: ' . $e->getMessage());
        } finally {
            $this->closeModal();
            $this->loadData();
        }
    }

    /**
     * Ob'ektni o'chirish.
     * Deletes an object.
     */
    public function delete()
    {
        if ($this->actionType !== 'delete') {
            Session::flash('error', 'Invalid action type for delete.');
            return;
        }

        $message = '';
        try {
            if ($this->modalType === 'building' && $this->building_id) {
                Building::findOrFail($this->building_id)->delete();
                $message = 'Building deleted successfully!';
            } elseif ($this->modalType === 'floor' && $this->floor_id) {
                Floor::findOrFail($this->floor_id)->delete();
                $message = 'Floor deleted successfully!';
            } elseif ($this->modalType === 'room' && $this->room_id) {
                Room::findOrFail($this->room_id)->delete();
                $message = 'Room deleted successfully!';
            } elseif ($this->modalType === 'responsible-person' && $this->responsible_person_id) { // Mas'ul shaxsni o'chirish
                ResponsiblePerson::findOrFail($this->responsible_person_id)->delete();
                $message = 'Responsible person deleted successfully!';
            } elseif ($this->modalType === 'unassign-person-from-room' && $this->assign_person_room_id && $this->assign_person_id) {
                $room = Room::findOrFail($this->assign_person_room_id);
                $room->responsiblePeople()->detach($this->assign_person_id);
                $message = 'Responsible person unassigned from room successfully!';
            } else {
                Session::flash('error', 'No ID provided for deletion or invalid modal type.');
                return;
            }
            Session::flash('message', $message);
        } catch (\Exception $e) {
            Session::flash('error', 'An error occurred during deletion: ' . $e->getMessage());
            Log::error('Delete Error: ' . $e->getMessage());
        } finally {
            $this->closeModal();
            $this->loadData();
        }
    }

    // --- Helpers ---
    /**
     * Barcha form maydonlarini tozalash.
     * Resets all form fields to their initial state.
     */
    private function resetAllFields()
    {
        $this->building_id = null;
        $this->building_name = '';
        $this->building_address = '';
        $this->building_description = '';
        $this->building_is_active = true;

        $this->floor_id = null;
        $this->floor_number = '';
        $this->floor_level = '';
        $this->floor_description = '';
        $this->floor_is_active = true;

        $this->room_id = null;
        $this->number = ''; // 'number' o'rniga 'number'
        $this->room_name = '';
        $this->room_description = '';
        $this->room_is_active = true;

        $this->responsible_person_id = null;
        $this->responsible_person_full_name = '';
        $this->responsible_person_phone = '';
        $this->responsible_person_passport_pdf_path = '';
        $this->responsible_person_is_active = true;

        $this->assign_person_room_id = null;
        $this->assign_person_id = null;

        $this->selectedBuildingId = null;
        $this->selectedFloorId = null;
    }
}
