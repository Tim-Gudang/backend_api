
namespace App\Services;

use App\Models\Satuan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class UnitService
{
    public function getAllUnits()
    {
        return Satuan::with('user')->paginate(10);
    }

    public function createUnit(array $data)
    {
        try {
            DB::beginTransaction();
            $data['slug'] = Str::slug($data['name']);
            $data['user_id'] = auth()->id();
            $unit = Satuan::create($data);
            DB::commit();
            return $unit;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception('Gagal menambah satuan barang', 500);
        }
    }

    public function getUnitById($id)
    {
        return Satuan::findOrFail($id);
    }

    public function updateUnit($id, array $data)
    {
        try {
            DB::beginTransaction();
            $unit = Satuan::findOrFail($id);
            $data['slug'] = Str::slug($data['name']);
            $data['user_id'] = auth()->id();
            $unit->update($data);
            DB::commit();
            return $unit;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception('Gagal mengubah satuan barang', 500);
        }
    }

    public function deleteUnit($id)
    {
        $unit = Satuan::findOrFail($id);
        $unit->delete();
    }

    public function restoreUnit($id)
    {
        $unit = Satuan::onlyTrashed()->findOrFail($id);
        $unit->restore();
        return $unit;
    }

    public function forceDeleteUnit($id)
    {
        $unit = Satuan::onlyTrashed()->findOrFail($id);
        $unit->forceDelete();
    }
}
