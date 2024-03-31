<?php

namespace App\Http\Controllers\Calculator;

use App\Http\Controllers\Controller;
use App\Models\Menghitung;
use Exception;
use Illuminate\Http\Request;

class CalculatorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Menghitung::orderBy('created_at');
        $menghitung = $query->paginate(12);

        return view('frontend.pages.kalkulus.index', [
            'menghitung' => $menghitung
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'equation' => 'required|string',
        ]);

        $coefficients = explode(',', $validatedData['equation']);
        $coefficients = array_map('trim', $coefficients);
        $result = '';

        try {
            switch (count($coefficients)) {
                case 2:
                    [$a, $b] = $coefficients;
                    $result = $this->solveLinearEquation((float)$a, (float)$b);
                    break;
                case 3:
                    [$a, $b, $c] = $coefficients;
                    $result = $this->solveQuadraticEquation((float)$a, (float)$b, (float)$c);
                    break;
                default:
                    throw new Exception("Format persamaan tidak diketahui.");
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }

        $calculation = Menghitung::create([
            'equation' => $validatedData['equation'],
            'type' => count($coefficients) == 2 ? 'linear' : 'quadratic',
            'result' => $result,
        ]);

        return response()->json([
            'type' => count($coefficients) == 2 ? 'Linear' : 'Quadratic',
            'result' => $result,
            'calculation_id' => $calculation->id
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    protected function solveLinearEquation($a, $b)
    {
        if ($a == 0) {
            throw new Exception("Tidak ada solusi atau solusi tak terhingga.");
        }

        $sign = $b < 0 ? "" : "+";

        $step1 = "Langkah 1 : {$a}x {$sign} {$b} = 0";
        $step2 = "Langkah 2 : {$a}x = " . (-$b);
        $step3 = "Langkah 3 : x = " . (-$b) . " / {$a}";
        $step4 = "Langkah 4 : x = " . ((-$b) / $a);

        $result = $step1 . "<br>" . $step2 . "<br>" . $step3 . "<br>" . $step4;
        return $result;
    }

    protected function solveQuadraticEquation($a, $b, $c)
    {
        $D = pow($b, 2) - 4 * $a * $c;
        $steps = "Langkah 1 : Hitung, D = b^2 - 4ac = ({$b})^2 - 4*({$a})*({$c}) = {$D}<br>";

        if ($D > 0) {
            $x1 = (-$b + sqrt($D)) / (2 * $a);
            $x2 = (-$b - sqrt($D)) / (2 * $a);
            $steps .= "Langkah 2 : D > 0, ada dua solusi nyata.<br>";
            $steps .= "Langkah 3 : Hitung x1 = (-b + √D) / (2a) = (-{$b} + √{$D}) / (2*{$a}) = {$x1}<br>";
            $steps .= "Langkah 4 : Hitung x2 = (-b - √D) / (2a) = (-{$b} - √{$D}) / (2*{$a}) = {$x2}";
        } elseif ($D == 0) {
            $x = -$b / (2 * $a);
            $steps .= "Langkah 2 : D = 0, ada satu solusi nyata.<br>";
            $steps .= "Langkah 3 : Hitung x = -b / (2a) = -({$b}) / (2*{$a}) = {$x}";
        } else {
            $realPart = -$b / (2 * $a);
            $imaginaryPart = sqrt(-$D) / (2 * $a);
            $steps .= "Langkah 2 : D < 0, solusi berupa bilangan kompleks.<br>";
            $steps .= "Langkah 3 : Bagian real x = -b / (2a) = -({$b}) / (2*{$a}) = {$realPart}<br>";
            $steps .= "Langkah 4 : Bagian imajiner x = √(-D) / (2a) = √(-{$D}) / (2*{$a}) = {$imaginaryPart}<br>";
            $steps .= "Jadi, solusi kompleksnya adalah: x1 = {$realPart} + {$imaginaryPart}i dan x2 = {$realPart} - {$imaginaryPart}i";
        }

        return $steps;
    }
}
