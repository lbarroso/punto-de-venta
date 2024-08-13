<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            Nombre de empresa:
            {{ Form::text('regnom', $empresa->regnom, ['class' => 'form-control' . ($errors->has('regnom') ? ' is-invalid' : ''), 'placeholder' => 'Regnom']) }}
            {!! $errors->first('regnom', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            Teléfono
            {{ Form::text('regtel', $empresa->regtel, ['class' => 'form-control' . ($errors->has('regtel') ? ' is-invalid' : ''), 'placeholder' => 'Regtel']) }}
            {!! $errors->first('regtel', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            Correo electrónico
            {{ Form::text('regemail', $empresa->regemail, ['class' => 'form-control' . ($errors->has('regemail') ? ' is-invalid' : ''), 'placeholder' => 'Regemail']) }}
            {!! $errors->first('regemail', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            Municipio:
            {{ Form::text('regmun', $empresa->regmun, ['class' => 'form-control' . ($errors->has('regmun') ? ' is-invalid' : ''), 'placeholder' => 'Regmun']) }}
            {!! $errors->first('regmun', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            Localidad:
            {{ Form::text('regloc', $empresa->regloc, ['class' => 'form-control' . ($errors->has('regloc') ? ' is-invalid' : ''), 'placeholder' => 'Regloc']) }}
            {!! $errors->first('regloc', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            Estado:
            {{ Form::text('regedo', $empresa->regedo, ['class' => 'form-control' . ($errors->has('regedo') ? ' is-invalid' : ''), 'placeholder' => 'Regedo']) }}
            {!! $errors->first('regedo', '<div class="invalid-feedback">:message</div>') !!}
        </div>
		
		<div class="form-row">
			<div class="form-group col-md-6">
				<div class="form-group">
					Facebook:
					{{ Form::text('facebook', $empresa->facebook, ['class' => 'form-control' . ($errors->has('facebook') ? ' is-invalid' : ''), 'placeholder' => 'http://www.facebook.com']) }}
					{!! $errors->first('facebook', '<div class="invalid-feedback">:message</div>') !!}
				</div>			
			</div>
			<div class="form-group col-md-6">
				<div class="form-group">
					Instagram:
					{{ Form::text('instagram', $empresa->instagram, ['class' => 'form-control' . ($errors->has('instagram') ? ' is-invalid' : ''), 'placeholder' => 'http://www.instagram.com']) }}
					{!! $errors->first('instagram', '<div class="invalid-feedback">:message</div>') !!}
				</div>				
			</div>			
		</div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary"> Aceptar </button>
		<a href="{{ route('empresas.index') }}" class="btn btn-default"> Cancelar </a>
    </div>
</div>