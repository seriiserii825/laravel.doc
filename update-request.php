<?php
class UpdateSalaryRequest extends FormRequest
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
          ->ignore($this->salary)
          ->where('employee_id', $this->employee_id)
          ->where('month', $this->month)
      ],
      'amount' => 'required',
      'date' => 'nullable',
      'month' => 'nullable',
      'year' => 'nullable',
    ];
  }

  public function messages()
  {
    return [
      'employee_id.unique' => 'Combination of Employee id & month is not unique',
    ];
  }

  public function rules()
  {
    return [
      'name' => [
        'required',
        Rule::unique('categories')->ignore($this->category)
      ],
      'status' => 'required|integer',
    ];
  }
}
