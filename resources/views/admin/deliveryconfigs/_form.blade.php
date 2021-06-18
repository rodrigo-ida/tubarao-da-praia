
{{ csrf_field() }}
<div class="form-group">
    <table class="table table-hover table-dark">
        <thead>
            <tr>
                <th>Dia</th>
                <th>Hora abertura</th>
                <th>Hora fechamento</th>
            </tr>
        </thead>
        <tbody>
        <tr>
            <td>Segunda-feira</td>
            <td>

                <select name="config_time[]" id="config_time_segunda">
                    
                    @foreach($horas as $time)
                        <option value="{{ $time }}">{{ $time }}</option>
                    @endforeach

                </select>            
            
            </td>
            <td>

                <select name="config_time_end[]" id="config_time_segunda">
                    
                    @foreach($horas as $time)
                        <option value="{{ $time }}">{{ $time }}</option>
                    @endforeach

                </select>            
            
            </td>
        </tr>
        <tr>
            <td>Terça-feira</td>
            <td>

                <select name="config_time[]" id="config_time_terca">
                    
                    @foreach($horas as $time)
                        <option value="{{ $time }}">{{ $time }}</option>
                    @endforeach

                </select>            
            
            </td>
            <td>

                <select name="config_time_end[]" id="config_time_terca">
                    
                    @foreach($horas as $time)
                        <option value="{{ $time }}">{{ $time }}</option>
                    @endforeach

                </select>            
            
            </td>
        </tr>
        <tr>
            <td>Quarta-feira</td>
            <td>

                <select name="config_time[]" id="config_time_quarta">
                    
                    @foreach($horas as $time)
                        <option value="{{ $time }}">{{ $time }}</option>
                    @endforeach

                </select>            
            
            </td>
            <td>

                <select name="config_time_end[]" id="config_time_quarta">
                    
                    @foreach($horas as $time)
                        <option value="{{ $time }}">{{ $time }}</option>
                    @endforeach

                </select>            
            
            </td>
        </tr>
        <tr>
            <td>Quinta-feira</td>
            <td>

                <select name="config_time[]" id="config_time_quinta">
                    
                    @foreach($horas as $time)
                        <option value="{{ $time }}">{{ $time }}</option>
                    @endforeach

                </select>            
            
            </td>
            <td>

                <select name="config_time_end[]" id="config_time_quinta">
                    
                    @foreach($horas as $time)
                        <option value="{{ $time }}">{{ $time }}</option>
                    @endforeach

                </select>            
            
            </td>
        </tr>
        <tr>
            <td>Sexta-feira</td>
            <td>

                <select name="config_time[]" id="config_time_sexta">
                    
                    @foreach($horas as $time)
                        <option value="{{ $time }}">{{ $time }}</option>
                    @endforeach

                </select>            
            
            </td>
            <td>

                <select name="config_time_end[]" id="config_time_sexta">
                    
                    @foreach($horas as $time)
                        <option value="{{ $time }}">{{ $time }}</option>
                    @endforeach

                </select>            
            
            </td>
        </tr>
        <tr>
            <td>Sábado</td>
            <td>

                <select name="config_time[]" id="config_time_sabado">
                    
                    @foreach($horas as $time)
                        <option value="{{ $time }}">{{ $time }}</option>
                    @endforeach

                </select>            
            
            </td>
            <td>

                <select name="config_time_end[]" id="config_time_sabado">
                    
                    @foreach($horas as $time)
                        <option value="{{ $time }}">{{ $time }}</option>
                    @endforeach

                </select>            
            
            </td>
        </tr>
        <tr>
            <td>Domingo</td>
            <td>

                <select name="config_time[]" id="config_time_domingo">
                    
                    @foreach($horas as $time)
                        <option value="{{ $time }}">{{ $time }}</option>
                    @endforeach

                </select>            
            
            </td>
            <td>

                <select name="config_time_end[]" id="config_time_domingo">
                    
                    @foreach($horas as $time)
                        <option value="{{ $time }}">{{ $time }}</option>
                    @endforeach

                </select>            
            
            </td>
        </tr>
    </table>
</div>
<div class="form-group">
    {{ Form::label('Loja', 'Loja') }}
    {{ Form::select('config_loja_id', $lojas) }}
</div>
<div class="checkbox">
Status:
    <label>
        {{ Form::radio('config_status', '1') }}
        Ativado
    </label>
    <label>
        {{ Form::radio('config_status', '0')}}
        Desativado
    </label>
</div>