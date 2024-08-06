interface IModel {
  id: number;
  name: string;
  created_by: string;
  updated_by: string;
  created_at: string;
  updated_at: string;
}

const models: Array<IModel> = [];

export type { IModel };

export default models;
