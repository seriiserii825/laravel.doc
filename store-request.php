<?php

class StoreSalaryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'employee_id' =>  [
                'required',
                Rule::unique('salaries')
                    ->where('employee_id', $this->employee_id)
                    ->where('month', $this->month)
            ],
            'amount' => 'required',
            'date' => 'required',
            'month' => 'required',
            'year' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'employee_id.unique' => 'Combination of Employee id & month is not unique',
        ];
    }
}

?>
