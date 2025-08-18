<form method="POST" action="<?= BASE_URL ?>/depoimento/adicionar">
  <div class="container my-5">
    <div class="row">
      <div class="col-md-12">
        <div class="mb-3">
          <label for="id_cliente" class="form-label">Cliente:</label>
          <select class="form-control" id="id_cliente" name="id_cliente" required>
            <option value="">Selecione um cliente</option>
            <?php foreach ($cliente as $c): ?>
              <option value="<?= $c['id_cliente'] ?>"><?= $c['nome_cliente'] ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="mb-3">
          <label for="descricao_depoimento" class="form-label">Depoimento:</label>
          <textarea class="form-control" id="descricao_depoimento" name="descricao_depoimento" rows="5" required></textarea>
        </div>

        <div class="mb-3">
          <label for="nota_depoimento" class="form-label">Nota:</label>
          <select class="form-control" id="nota_depoimento" name="nota_depoimento" required>
            <option value="">Selecione</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
          </select>
        </div>

        <div class="mb-3">
          <label for="status_depoimento" class="form-label">Status:</label>
          <select class="form-control" id="status_depoimento" name="status_depoimento" required>
            <option value="Aprovado">Aprovado</option>
            <option value="Pendente">Pendente</option>
          </select>
        </div>

        <div class="mt-4 text-end">
          <button type="submit" class="btn btn-success">Salvar</button>
          <button type="button" class="btn btn-secondary">Cancelar</button>
        </div>
      </div>
    </div>
  </div>
</form>
