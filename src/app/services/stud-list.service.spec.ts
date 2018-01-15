import { TestBed, inject } from '@angular/core/testing';

import { StudListService } from './stud-list.service';

describe('StudListService', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [StudListService]
    });
  });

  it('should be created', inject([StudListService], (service: StudListService) => {
    expect(service).toBeTruthy();
  }));
});
